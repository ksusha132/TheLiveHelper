<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Mail; // фасад для отправки почты
use App\Code;
use App\Http\Controllers\CodeController;
use Illuminate\Support\Facades\Auth;
use App\Role;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'CaptchaCode' => 'required|valid_captcha'
        ]);
    }

    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        };
        // $user = $this->create($request->all());
        $user = new user();
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->save();
        $user->roles()->attach(Role::where('name','User')->first());
        //создаем код и записываем код
        $code = CodeController::generateCode(8);
        Code::create([
            'user_id' => $user->id,
            'code' => $code,
        ]);
        //Генерируем ссылку и отправляем письмо на указанный адрес
        $url = url('/') . '/auth/activate?id=' . $user->id . '&code=' . $code;
        Mail::send('emails.registration', array('url' => $url), function ($message) use ($request) {
            $message->to($request->email)->subject('Registration');
        });

        return 'Регистрация прошла успешно, на Ваш email отправлено письмо со ссылкой для активации аккаунта';
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);


    }

    public function activate(Request $request)
    {

        $res = Code::where('user_id', $request->id)
            ->where('code', $request->code)
            ->first();
        if ($res) {
            //Удаляем использованный код
            $res->delete();
            //активируем аккаунт пользователя
            $user = User::find($request->id);
            $user->activated = 1;
            $user->save();

            //редиректим на страницу авторизации с сообщением об активации
            return redirect()->to('auth/login')->with(['message' => 'ok']);
        }
        return abort(404);
    }

    public function postLogin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'activated' => 1])) {
            return redirect()->to('');
        }
        return redirect()->to('auth/login');
    }

}
