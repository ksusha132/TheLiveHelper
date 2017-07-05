<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Calendar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Storage;
use App\type_trains;
use App\trains;
use App\meals;
use App\sleep;
use App\Message;
use App\Conversations;
use DB;


class ConversationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_send_message()
    {
        return view('conversations.send_message'); // возвращает форму отправки сообщения


    }

    public function post_send_message(Request $request)
    {
        $message = new Message(); // создаем новое сообещение
        $message->id_user = Auth::user()->id; // залигинениый пользователь котор отправил сообщение
        $message->message = $request->message; // текст сообщения

        if ($request->has('id_user')) {
            $user_receive = User::find($request->id_user); // ищем пользователя которому отправили сообщение  $request->sentto - вшито в форме на его странице
            $previous_conversations = Auth::user()->conversations->intersect($user_receive->conversations); // ищем пересечение диалогов между пользователями
            if (!$previous_conversations->isEmpty()) { // если существуют такие диалоги то
                foreach ($previous_conversations as $conversation) { // проходимся по этим диалогам и ищем далог в котором
                    if ($conversation->users->count() == 2) { // количество пользователей  = 2
                        $message->id_conversation = $conversation->id_conversation; // в таком случае добавляем это сообщение в диалог(найденный)
                        break;
                    }
                }
            } else {
                $conversation = new Conversations(); // создаем новый диалог
                $conversation->save();
                $message->id_conversation = $conversation->id_conversation; // привязываем наше сообщение к созданному диалогу
                Auth::user()->conversations()->attach($conversation); // залогиненый пользователь привязфвается к диалогу который мы создали
                $user_receive->conversations()->attach($conversation); // пользователь, который принял сообщение тоже привязвается к этому диалогу
            }
            $message->save(); // помещаем собщение в диалог
            Auth::user()->Message()->attach($message, ['status' => 1]); // привязывается сообщение короторе пользователь отправил
            $user_receive->Message()->attach($message); // привязывается сообщение короторе пользователь принял
            return redirect('conversations/' . $message->id_conversation);

        } elseif ($request->has('id_conversation')) {
            $message->id_conversation = $request->id_conversation; // сразу в диалог
            $message->save(); // помещаем собщение в диалог
            $participants = Conversations::find($request->id_conversation)->users()->get(); // получаем членов беседы(диалога)
            foreach ($participants as $participant) {
                if ($participant->id == Auth::user()->id) { // если мы отправили сообщение оно должно быть прочитанным у нас в диалоге
                    $participant->Message()->attach($message, ['status' => 1]); // примваиваем статус 1 прочитано
                } else {
                    $participant->Message()->attach($message); // привязываем пользователей к сообщению
                }
            }
            return redirect()->back();
        }
    }

    public function show_conversations()
    {
        $conversations = Auth::user()->conversations()->with('users')->orderBy('updated_at', 'desc')->simplePaginate(2); // получили диалоги пользователя залогиненого and his fucking messages;

        foreach ($conversations as &$conversation) { // для того чтобы получить последнее сообщение
            $conversation->last_message = Auth::user()->Message()->where('id_conversation', $conversation->id_conversation)->orderBy('id_message', 'desc')->first(); // поле ласт месс из нашего диалога = берем сообщение залогиненого пользователя у которого id_conversation будет равно id_conversation текущего диалога сортируем по id_messa
            $last_message = $conversation->last_message; // последнее сообщение
            $conversation->author = $conversation->users->filter(function ($item) use ($last_message) { // создается элемент массива автор, который берется из масива юзер отфильтрованного по id
                return $item->id == $last_message->id_user; // id из  массива users = id_user из массива last message
            })->first(); //
        }


        return view('conversations.show_conversations', ['conversations' => $conversations]);


    }

    public function show_conversation($id_conversation)
    {
        $participants = Conversations::find($id_conversation)->users->keyBy('id'); // получили пользователей из текущего диалога
        $messages = Auth::user()->Message()->where('id_conversation', $id_conversation)->orderBy('id_message', 'asc')->take(16)->get(); // получили 16 сообщений выбранного диалога
        return view('conversations.show_conversation', ['participants' => $participants, 'messages' => $messages]);

    }

    public function delete_message(Request $request)
    {
        $message = message::find($request->id_message);
        Auth::user()->message()->detach($message);
        $users = $message->users()->get(); // ище пользователей которые прикреплены к сообщению
        if ($users->isEmpty()) { // если все удалили сообщение у себя
            $message->delete(); // удаляем из базы
        }
        echo json_encode(array('status' => 'OK'));
    }

    public function get_messages(Request $request)
    {
        if ($request->ajax()) {
            $messages = Auth::user()->Message()->where([['Message.id_message', '>', $request->id_message], ['Message.id_conversation', $request->id_conversation]])->get();
            echo json_encode(array('messages' => $messages), JSON_UNESCAPED_UNICODE);
        }
    }

    public function read_message(Request $request)
    {
        Auth::user()->Message()->updateExistingPivot($request->id_message, ['status' => 1]); // меняем его статус на прочитано
        echo json_encode(array('status' => 1));
    }


}
