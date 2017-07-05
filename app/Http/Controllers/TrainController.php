<?php
namespace App\Http\Controllers;

use App\sets;
use Calendar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Storage;
use App\type_trains;
use App\trains;
use App\exercises;
use App\Recommendations;
use DB;
use Validator;
use App\Weight;

class TrainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function delete_train($id_train)
    {
        $train = trains::find($id_train);

        $date = date_parse_from_format("Y-m-d", $train->date);
        $train->delete();
        return redirect()->to('/user/day/' . $date['year'] . '/' . $date['month'] . '/' . $date['day']);
    }

    public function get_edit_train($id_train)
    {
        $train = trains::find($id_train); //
        $train->timestart = date('H:i', strtotime($train->timestart));
        $train->timeend = date('H:i', strtotime($train->timeend));
        $type_trains = type_trains::pluck('type_name', 'id_type'); // все типы трень
        return view('train.edit_train', ['train' => $train, 'type_trains' => $type_trains, 'date' => date('Y/n/j', strtotime($train->date))]); // передайм во вью весь массив с тренями
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'timestart' => 'required|max:5|date_format:H:i|before:timeend',
            'timeend' => 'required|max:5|date_format:H:i|after:timestart',
            'average_pulse' => 'max:3',
            'id_type' => 'required'
        ]);
    }

    public function post_edit_train(Request $request, $id_train)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };

        $train = trains::find($id_train);

        $train->timestart = $request->timestart;
        $train->timeend = $request->timeend;
        $train->average_pulse = $request->average_pulse;
        $train->id_type = $request->id_type;


        $train->save();
        return redirect()->to('train/edit_train/' . $id_train);
    }


    public function get_create_train($year, $month, $day)
    {
        $type_trains = type_trains::all(); // полуаем все типы тренировок
        return view('train.create_train', ['type_trains' => $type_trains]); // передайм во вью
    }

    public function get_create_client_train($year, $month, $day)
    {
        $type_trains = type_trains::all(); // полуаем все типы тренировок
        $friends = Auth::user()->getFriends();
        return view('train.create_client_train', ['type_trains' => $type_trains, 'friends' => $friends]); // передайм во вью
    }

    public function post_create_client_train($year, $month, $day, Request $request)
    {
        $client = User::find($request->id_user); // client
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };
        if (Auth::user()->id == $request->id_user && Auth::user()->isFriendWith($client)) {
            return redirect()->back();
        } else {
            $train = new trains;
            $train->timestart = $request->timestart;
            $train->timeend = $request->timeend;
            $train->date = $year . '-' . $month . '-' . $day;
            $train->id_type = $request->id_type;
            $train->id_user = $request->friend; // получаем наших клиентов друзей
            $train->save();
            Auth::user()->client_trains()->attach($train); // привязываем тренера к тренировке
            return redirect()->to('/user/day/' . $year . '/' . $month . '/' . $day);
        }
    }


    public function post_create_train($year, $month, $day, Request $request)
    {

        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };

        $train = new trains;
        $train->timestart = $request->timestart;
        $train->timeend = $request->timeend;
        $train->average_pulse = $request->average_pulse;
        //$train->id_trainer = $request->id_trainer;
        $train->date = $year . '-' . $month . '-' . $day;
        $train->id_type = $request->id_type;
        $train->id_user = Auth::user()->id; // чтобы сохранял того юзера который авторизован
        $train->save();
        return redirect()->to('/user/day/' . $year . '/' . $month . '/' . $day);
    }

    public function get_create_set($id_train)
    {
        $train = trains::find($id_train);// ищем треню по айди руки-руки ноги-ноги
        $exercises = exercises::where('id_type', $train->id_type)->get(); // id type с текущей трени ищем упражение по типу тренировки
        return view('train.create_set', ['exercises' => $exercises]);
    }

    public function post_create_set($id_train, Request $request)
    {
        $set = new sets();
        $set->set_num = $request->set_num;
        $set->reps = $request->reps;
        $set->weight = $request->weight;
        $set->id_ex = $request->id_ex; // берем из того что мы ввели во вью (get)
        $set->id_train = $request->id_train;
        $set->save();
        return redirect()->to('/train/show_sets/' . $set->id_train);

    }

    public function show_sets($id_train)
    {
        $train = trains::find($id_train);// ищем треню по айди руки-руки ноги-ноги
        $exercises = exercises::where('id_type', $train->id_type)->get(); // id type с текущей трени ищем упражение по типу тренировки
        $sets = sets::where('id_train', $id_train)->with('exercises')->get(); // ищем все сеты по id_train + получаем названия тренировок (вместо джоин)
        return view('train.show_sets', ['sets' => $sets, 'exercises' => $exercises, 'date' => date('Y/n/j', strtotime($train->date))]);
    }

    public function get_edit_set($id_set)
    {
        $set = sets::find($id_set); // ищем сет
        $train = trains::find($set->id_train); // ищем тренировку этого сета
        $exercises = exercises::where('id_type', $train->id_type)->get()->pluck('name', 'id_ex'); // получаем упражнения по типу тренировки этого сета
        return view('train.edit_set', ['set' => $set, 'exercises' => $exercises, 'train' => $train]);
    }


    public function post_edit_set($id_set, Request $request)
    {
        $set = sets::find($id_set);

        $set->set_num = $request->set_num;
        $set->reps = $request->reps;
        $set->weight = $request->weight;
        $set->id_ex = $request->id_ex;


        $set->save();
        return redirect()->to('train/show_sets/' . $set->id_train);
    }

    public function delete_set($id_set)
    {
        $set = sets::find($id_set);
        $set->delete();
        return redirect('train/show_sets/' . $set->id_train);
    }

    public function draw_graph($date)
    {
        $output['cols'] = array(
            array('id' => '', 'label' => 'Title', 'pattern' => '', 'type' => 'string'),
            array('id' => '', 'label' => 'Count', 'pattern' => '', 'type' => 'number')
        );
        $stattrains = DB::select('select count(id_train) as cou_tr, type_trains.type_name from trains inner join type_trains on trains.id_type = type_trains.id_type where month(date) = ? and id_user = ? group by trains.id_type', [date('n', strtotime($date)), Auth::user()->id]);
        foreach ($stattrains as $traintype) {
            $output['rows'][] = array('c' => array(array('v' => $traintype->type_name, 'f' => null), array('v' => $traintype->cou_tr, 'f' => null)));
        }
        echo json_encode($output);
    }

    public function get_recommendations()
    {
        $recommend = Recommendations::where('id_user', Auth::user()->id)->first();
        if (!empty($recommend)) {
            $content = json_decode($recommend->content);// вывод получаем
            $day = $content->day;
            $recommendation = $content->recommendation;
            $useful = $recommend->useful;
            $goal = $content->goal;
            $count_days = $content->count_days;
            $life_style = $content->life_style;
            $date_start = $recommend->date_start_programm;
            $date_end = $recommend->date_end_programm;

        } else {
            $day = array();
            $recommendation = '';
            $goal = '';
            $count_days = '';
            $life_style = '';
            $date_start = '';
            $date_end = '';
        }
        return view('user.recommendations', ['day' => $day, 'recommend' => $recommend, 'recommendation' => $recommendation, 'date_start_programm' => $date_start, 'date_end_programm' => $date_end, 'goal' => $goal, 'count_days' => $count_days, 'life_style' => $life_style]);
    }

    public function approve($id_recommendation)
    {
        $recommendation = Recommendations::where('id_recommendation', $id_recommendation)->where('id_user', Auth::user()->id)->first();
        if (!empty($recommendation)) {
            $recommendation->useful = 1;
            $recommendation->save();
            return redirect()->back();
        }
    }

    public function show_succesful_recommendations()
    {
        $succesful_recommendations = Recommendations::where('useful', 1)->where('id_user', Auth::user()->id)->get();
        foreach($succesful_recommendations as &$succesful_recommendation){
            $content = json_decode($succesful_recommendation->content);
            $succesful_recommendation->day = $content->day;
        }
        return view('user.succesful_recommendations', ['succesful_recommendations' => $succesful_recommendations]);
    }


    public function post_recommendations(Request $request)
    {
        $type_trains = type_trains::with('exercises')->get();
        $count_days = $request->count_days;
        switch ($request->id_question) {
            case 1:
                $recommendation = 'You should do any cardio exercises. But! You shoud do it in range between 120 - 150 HRM. Check of your parameters.(age, weight and height)';
                $goal = 'To lose overweight';
                break;
            case 2:
                $recommendation = "You'll get set of exercises which consist simple exercises with little difficulty. For your goal, our team recommend you to do circle train(you do exercises with little rest about 20 seconds between sets)";
                $goal = 'To lose overweight and gain muscles';
                foreach ($type_trains as &$type_train) {
                    $type_train->exercises_filtered = collect($type_train->exercises->filter(function ($item) {
                        return $item->difficulty == 0 || $item->category == 1;
                    })->values()->all());
                }
                break;
            case 3:
                $recommendation = "You'll get set of exercises which consist base exercises with big difficulty. For your goal, our team recommend you to do hard train with big weight BUT!(If you feel any pain you should stop!)";
                $goal = 'To gain muscles';
                foreach ($type_trains as &$type_train) {
                    $type_train->exercises_filtered = collect($type_train->exercises->filter(function ($item) {
                        return $item->difficulty == 1 || $item->category == 1;
                    })->values()->all());
                }
                break;
            case 4:
                $recommendation = "You'll get set of exercises which help you to support your body. These exercises have little difficulty and they aren't base";
                $goal = 'To save my form';
                foreach ($type_trains as &$type_train) {
                    $type_train->exercises_filtered = collect($type_train->exercises->filter(function ($item) {
                        return $item->difficulty == 0 || $item->category == 0;
                    })->values()->all());
                }
                break;
        }
        $day = array();
        if ($request->id_question != 1) {
            switch ($count_days) {
                case 1:
                    $count_exercises_day = 14;

                    $random_type_trains = $type_trains->random(2)->values();
                    foreach ($random_type_trains as &$type_train) {
                        $type_train->exercises_filtered_final = $type_train->exercises_filtered->random(6)->values();
                        $day[0][] = $type_train;
                    }

                    break;
                case 2:
                    $count_exercises_day = 14;
                    $random_type_trains = $type_trains->random(4)->values();
                    foreach ($random_type_trains as $key => &$type_train) {
                        $type_train->exercises_filtered_final = $type_train->exercises_filtered->random(6)->values();
                        if ($key % 2 == 0) {
                            $day[0][] = $type_train;
                        } else {
                            $day[1][] = $type_train;
                        }
                    }
                    break;
                case 3:
                    $count_exercises_day = 14;
                    $random_type_trains = $type_trains->random(6)->values();
                    foreach ($random_type_trains as $key => &$type_train) {
                        $type_train->exercises_filtered_final = $type_train->exercises_filtered->random(6)->values();
                        if ($key % 3 == 0) {
                            $day[0][] = $type_train;
                        } elseif ($key % 2 != 0 && $key % 3 != 0) {
                            $day[1][] = $type_train;
                        } else {
                            $day[2][] = $type_train;
                        }
                    }
                    break;
                case 4:
                    $random_type_trains = $type_trains->random(6)->values();
                    foreach ($random_type_trains as $key => &$type_train) {
                        $type_train->exercises_filtered_final = $type_train->exercises_filtered->random(6)->values();
                    }
                    for ($i = 0; $i < 2; $i++) {
                        $day[$i][] = $random_type_trains[$i];
                    }
                    for ($i = 2; $i < 4; $i++) {
                        $day[$i][] = $random_type_trains[$i];
                        $day[$i][] = $random_type_trains[$i + 1];
                    }
                    break;
                case 5:
                    $random_type_trains = $type_trains->random(6)->values();
                    foreach ($random_type_trains as $key => &$type_train) {
                        $type_train->exercises_filtered_final = $type_train->exercises_filtered->random(6)->values();
                    }
                    for ($i = 0; $i < 4; $i++) {
                        $day[$i][] = $random_type_trains[$i];
                    }
                    for ($i = 4; $i < 5; $i++) {
                        $day[$i][] = $random_type_trains[$i];
                        $day[$i][] = $random_type_trains[$i + 1];
                    }
                    break;
                case 6:
                    $random_type_trains = $type_trains->random(6)->values();
                    foreach ($random_type_trains as $key => &$type_train) {
                        $type_train->exercises_filtered_final = $type_train->exercises_filtered->random(6)->values();
                    }
                    for ($i = 0; $i < 6; $i++) {
                        $day[$i][] = $random_type_trains[$i];
                    }
                    break;
                case 7:
                    $random_type_trains = $type_trains->random(6)->values();
                    foreach ($random_type_trains as $key => &$type_train) {
                        $type_train->exercises_filtered_final = $type_train->exercises_filtered->random(6)->values();
                    }
                    for ($i = 0; $i < 6; $i++) {
                        $day[$i][] = $random_type_trains[$i];
                        if ($i == 5) {
                            $day[6][] = $random_type_trains[$i];
                        }
                    }
                    break;
            }
        }
        switch ($request->life_style) {
            case 'Sedentary':
                $recommendation .= '';
                break;
            case 'Small activity';
                $recommendation .= '';
                break;
            case 'Moderate activity';
                $recommendation .= '';
                break;
            case 'High activity';
                $recommendation .= '';
                break;

        }
        $recommend = Recommendations::where('id_user', Auth::user()->id)->where('useful', 0)->first();
        if (!empty($recommend)) {
            $recommend->content = json_encode(array('day' => $day, 'recommendation' => $recommendation, 'goal' => $goal, 'count_days' => $count_days, 'life_style' => $request->life_style), JSON_UNESCAPED_UNICODE);
            $recommend->goal = $request->id_question;
            $recommend->date_start_programm = $request->date_start_programm;
            $recommend->date_end_programm = $request->date_end_programm;
            $recommend->save();
        } else {
            $recommend = new Recommendations();
            $recommend->id_user = Auth::user()->id;
            $recommend->goal = $request->id_question;
            $recommend->date_start_programm = $request->date_start_programm;
            $recommend->date_end_programm = $request->date_end_programm;
            $recommend->weight_start = Auth::user()->weight;
            $recommend->muscle_weight_start = Auth::user()->muscle_weight;
            $recommend->active_nuclear_weight_start = Auth::user()->active_nuclear_weight;
            $recommend->content = json_encode(array('day' => $day, 'recommendation' => $recommendation, 'goal' => $goal, 'count_days' => $count_days, 'life_style' => $request->life_style), JSON_UNESCAPED_UNICODE);
            $recommend->save();
        }
        return view('user.recommendations', ['day' => $day, 'recommend' => $recommend, 'recommendation' => $recommendation, 'goal' => $goal, 'count_days' => $count_days, 'life_style' => $request->life_style, 'date_start_programm' => $recommend->date_start_programm, 'date_end_programm' => $recommend->date_end_programm]);
    }

}
