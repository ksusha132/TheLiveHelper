<?php

namespace App\Http\Controllers\user;

use App\Photos;
use App\Recommendations;
use Calendar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Storage;
use App\type_trains;
use App\trains;
use App\meals;
use App\sleep;
use App\Reviews;
use App\Weight;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getEdit()
    {
        $user = User::find(Auth::user()->id); // get user
        $photos = Photos::where('id_user', Auth::user()->id)->get();
        return view('user.edit', ['user' => $user, 'photos' => $photos]); // transmit in view
    }

    public function postEdit(Request $request) // for writing
    {
        $user = User::find(Auth::user()->id); // find current user
        $user->name = $request->name;
        $user->age = $request->age;
        $user->education = $request->education;
        $user->achivements = $request->achivements;
        $user->current_goal = $request->current_goal;
        $user->muscle_weight = $request->muscle_weight;
        $user->desired_weight = $request->desired_weight;
        $user->active_nuclear_weight = $request->active_nuclear_weight;
        $user->weight = $request->weight;
        $user->height = $request->height;
        $user->sex = $request->sex;


        if ($request->hasFile('photo')) {
            if (!empty($user->photo)) {
                unlink(base_path() . '/public/images/users/' . $user->photo); //удаляем сатурю фотку
            }
            $imageName = $user->id . mt_rand(0, 99999) . sha1($user->name) . '.' .
                $request->file('photo')->getClientOriginalExtension(); // берет расширение
            $user->photo = $imageName;
            $request->file('photo')->move(
                base_path() . '/public/images/users/', $imageName
            );
        }

        $user->save();
        return redirect()->to('user/edit');
    }

    public function delete()
    {
        $user = User::find(Auth::user()->id);
        $user->delete();
        return redirect()->to('/');
    }

    public function show($id_user)
    { //если хотим посмотреть чужой профиль
        $user = User::find($id_user); // get user
        $photos = Photos::where('id_user', $id_user)->get();
        $recommendation = Recommendations::where('id_user', Auth::user()->id)->first();
        $reviews = $user->Reviews_received()->get();
        $trains = trains::select('date')->where('id_user', $id_user)->distinct()->get(); // нашли трени данного юзера
        $events = array();
        foreach ($trains as $train) {
            $events[] = $train['date'];
        }


        $data = array(
            'name' => 'ksusha',
            'url' => '/user/day/',
            'url_cal' => '/user/calendar/',
            'foo' => 'bar'
        );
        if (!empty($recommendation->goal)) {
            switch ($recommendation->goal) {
                case 1:
                    if ($recommendation->weight_start > $user->weight && $recommendation->muscle_weight_start < $user->muscle_weight && $recommendation->active_nuclear_weight_start < $user->active_nuclear_weight) {
                        $goal = true;
                    } else {
                        $goal = false;
                    }
                    break;
                case 2;
                    if ($recommendation->weight_start != $user->weight && $recommendation->muscle_weight_start < $user->muscle_weight && $recommendation->active_nuclear_weight_start < $user->active_nuclear_weight) {
                        $goal = true;
                    } else {
                        $goal = false;
                    }
                    break;
                case 3:
                    if ($recommendation->weight_start > $user->weight && $recommendation->muscle_weight_start < $user->muscle_weight && $recommendation->active_nuclear_weight_start < $user->active_nuclear_weight) {
                        $goal = true;
                    } else {
                        $goal = false;
                    }
                    break;
                case 4:
                    if ($recommendation->weight_start == $user->weight && $recommendation->muscle_weight_start == $user->muscle_weight && $recommendation->active_nuclear_weight_start == $user->active_nuclear_weight) {
                        $goal = true;
                    } else {
                        $goal = false;
                    }
                    break;
            }
        } else {
            $goal = "You don't have any goal.";
        }
        $calendar = Calendar::generate(null, null, $events, $data);
        $cur_data = date('Y-m-d');
        return view('user.show', ['user' => $user, 'calendar' => $calendar, 'reviews' => $reviews, 'photos' => $photos, 'recommendation' => $recommendation, 'goal' => $goal, 'cur_data' => $cur_data]); //  transmit user in view
    }

    public function calendar($year, $month, $id_user)
    {
        $trains = trains::select('date')->where('id_user', $id_user)->havingRaw('MONTH(date) = ' . $month . ' AND YEAR(date) = ' . $year)->distinct()->get(); // нашли трени данного юзера
        $events = array();
        foreach ($trains as $train) {
            $events[] = $train['date'];
        }
        $data = array(
            'url' => '/user/day/',
            'url_cal' => '/user/calendar/',
        );
        $calendar = Calendar::generate($year, $month, $events, $data);
        return $calendar;
    }

    public function show_day($year, $month, $day)
    {
        $sleep = sleep::where([['date', $year . '-' . $month . '-' . $day], ['id_user', Auth::user()->id]])->with('type_of_sleep')->get();
        $meals = meals::where([['date', $year . '-' . $month . '-' . $day], ['id_user', Auth::user()->id]])->get();
        $trains = trains::where([['date', $year . '-' . $month . '-' . $day], ['id_user', Auth::user()->id]])->get();
        $weight = Weight::where([['date', $year . '-' . $month . '-' . $day], ['id_user', Auth::user()->id]])->get();
        $clients_trains = Auth::user()->client_trains()->where('date', $year . '-' . $month . '-' . $day)->get(); // получаю тренировки которые есть у этого тренера по дате
        $trains->each(function ($train) {
            $train->timestart = date('H:i', strtotime($train->timestart));
            $train->timeend = date('H:i', strtotime($train->timeend));
        });

        return view('day.day', ['clients_trains' => $clients_trains, 'trains' => $trains, 'sleep' => $sleep, 'meals' => $meals, 'weight'=> $weight, 'date' => $year . '-' . $month . '-' . $day]); // передайм во вью
    }

    public function show_requests()
    {
        $requests = array(); // массив в который потом поместим юзеров
        foreach (Auth::user()->getFriendRequests() as $request) {
            $user1 = User::find($request->sender_id);
            $requests[] = $user1; // записываем юзера помещаем юзеров в массив
        }
        return view('user.show_requests', ['requests' => $requests]);
    }

    public function show_friends()
    {
        return view('user.show_friends', ['friends' => Auth::User()->getFriends($perPage = 20)]); // передаем пользователя во воью
    }


    public function add_to_friends($id_user)
    {
        $recipient = User::find($id_user);
        if (Auth::user()->hasRole('Trainer') && $recipient->hasRole('Trainer')) {
            return redirect()->back()->with('status', 'The friend request has not been sent. Bacause trainer can not add another trainer to friends')->with('type', 'danger');
        } else {
            Auth::user()->befriend($recipient); // отправила запрос в др
            return redirect()->back()->with('status', 'The friend request has been sent')->with('type', 'success');
        }
    }


    public function accept_to_friends($id_user)
    {
        $recipient = User::find($id_user); // ищем пользователей которые добавили в др
        Auth::user()->acceptFriendRequest($recipient); // я принимаю в др
        return redirect()->back()->with('status', 'The friend request has been accepted');
    }

    public function remove_from_friends($id_user)
    {
        $friend = User::find($id_user);
        Auth::user()->unfriend($friend); // я удаляю из друзей
        return redirect()->back()->with('status', 'The friend  has been removed');
    }

    public function add_to_blacklist($id_user)
    {
        $denided = User::find($id_user);
        Auth::user()->blockFriend($denided); // я добавялю в чс
        return redirect()->back()->with('status', 'The friend  has been blocked');

    }

    public function remove_from_blacklist($id_user)
    {
        $removers = User::find($id_user);
        Auth::user()->unblockFriend($removers); // я удаляю из черного списка
        return redirect()->back()->with('status', 'The friend  has been removed from black list');
    }

    public function deny_request($id_user)
    {
        $user = User::find($id_user);
        Auth::user()->denyFriendRequest($user);
        return redirect()->back()->with('status', "The user's request has been denied ");
    }

    public function get_alerts(Request $request)
    {
        if ($request->ajax()) {
            $messages = Auth::user()->Message()->where('status', 0)->get(); // забираем сообщения со статусом 0 - непрочитнные
            $requests = Auth::user()->getFriendRequests(); // количество реквестов
            echo json_encode(array('count' => count($messages), 'count_requests' => $requests), JSON_UNESCAPED_UNICODE);// количество непрочитанных сообщений
        }
    }

    public function search_person(Request $request)
    {
        $persons = User::where('name', 'like', '%' . $request->name . '%')
            ->orderBy('name')
            ->paginate(20);
        return view('user.search_person', ['persons' => $persons]);
    }

    public function sport_calculations()
    {
        $weight = Auth::user()->weight;
        $height = Auth::user()->height;
        $sex = Auth::user()->sex;
        $age = Auth::user()->age;
        if ($height == null) {
            return redirect()->back();
        }
        $IMT = $weight / ($height * $height / 10000); // индекс массы тела
        if ($sex == 'female') {
            $ROO = 24 * $weight * 0.9; // расчет основного обмена женщины
            $Harris_Benedict = 65.5 + (9.6 * $weight) + (1.8 * $height) - (4.7 * $age);
        } else {
            $ROO = 24 * $weight * 1; // расчет основного обмена женщины
            $Harris_Benedict = 66 + (13.7 * $weight) + (5 * $height) - (6.8 * $age);
        }

// расчет фактичекого калорий за сутки
        $RFC = array(
            'Sedentary' => array(
                'coeff' => 1.2,
                'description' => "You don't do any exercises. You mostly sit at the table."
            ),
            'Small activity' => array(
                'coeff' => 1.4,
                'description' => "Not very big activity. You do sports 1-2 times a week."
            ),
            'Moderate activity' => array(
                'coeff' => 1.6,
                'description' => 'Good physical activity. You do sports 3-5 times a week.'
            ),
            'High activity' => array(
                'coeff' => 1.8,
                'description' => 'Very big activity. You should slow down.'
            )
        );

        foreach ($RFC as &$type) {
            $type['value'] = $Harris_Benedict * $type['coeff'];

            // расчет необходимого потребления калорий в сутки
            $type['gain'] = $type['value'] + ($type['value'] * 0.15);
            $type['fat_burn'] = $type['value'] - ($type['value'] * 0.15);
            $type['constant_weight'] = $type['value'];
        }

        return view('user.sport_calculations', ['RFC' => $RFC, 'IMT' => $IMT, 'ROO' => $ROO, 'Harris_Benedict' => $Harris_Benedict]);
    }

    public function create_review(Request $request)
    {
        if (Auth::user()->id != $request->id_user) {
            $review = new Reviews();
            $review->review = $request->review;
            $review->id_user = Auth::user()->id; // тот кто написал отзыв
            $review->id_trainer = $request->id_user; // тренер ай ди
            $review->save();
            if (Auth::user()->hasRole('Admin')) {
                $role = 'Admin';
            } else {
                $role = 'User';
            }
            echo json_encode(array('role' => $role, 'review' => array('name' => Auth::user()->name, 'id_review' => $review->id_review, 'review' => $review->review)), JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(array());
        }
    }

    public function delete_review(Request $request)
    {
        if (Auth::user()->hasRole('Admin')) {
            $review = Reviews::find($request->id_review);
            $review->delete();
            echo json_encode(array('status' => 'OK'));
        } else {
            echo json_encode(array());
        }
    }

    public function upload_photo(Request $request)
    {
        if ($request->hasFile('photo')) {
            $photo = new Photos();
            $photo->id_user = Auth::user()->id;
            $imageName = Auth::user()->id . mt_rand(0, 99999) . '-' . sha1(Auth::user()->name) . '.' .
                $request->file('photo')->getClientOriginalExtension(); // берет расширение
            $request->file('photo')->move(
                base_path() . '/public/images/users/gallery/', $imageName
            );
            $photo->name = $imageName;
            $photo->save();
        }
        return redirect()->back();
    }

    public function delete_photo($id_photo)
    {
        $photo = Photos::find($id_photo);
        if (Auth::user()->id == $photo->id_user) {
            unlink(base_path() . '/public/images/users/gallery/' . $photo->name); //удаляем сатурю фотку
            $photo->delete();
        }
        return redirect()->back();
    }
}
