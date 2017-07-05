<?php

namespace App\Http\Controllers;

use App\meals;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\sets;
use Calendar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Vitamins;
use Illuminate\Support\Facades\Storage;
use App\eaten;
use App\food;
use App\trains;
use DB;
use Validator;

class FoodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'calories' => 'required|max:4',
            'gramm' => 'required|max:4',
            'id_food' => 'required'
        ]);
    }

    public function get_create_meal($year, $month, $day)
    {
        return view('food.create_meal');
    }

    public function post_create_meal($year, $month, $day, Request $request)
    {
        $meal = new meals();
        $meal->time = $request->time;
        $meal->date = $year . '-' . $month . '-' . $day;
        $meal->id_user = Auth::user()->id; // чтобы сохранял того юзера который авторизован
        $meal->save();
        return redirect()->to('/user/day/' . $year . '/' . $month . '/' . $day);
    }

    public function get_edit_meal($id_meal)
    {
        $meal = meals::find($id_meal);
        return view('food.edit_meal', ['meal' => $meal, 'date' => date('Y/n/j', strtotime($meal->date))]); // чтобы прогрузилось что есть в базе
    }

    public function post_edit_meal($id_meal, Request $request)
    {
        $meal = meals::find($id_meal);

        $meal->time = $request->time;

        $meal->save();
        return redirect()->to('food/edit_meal/' . $id_meal);
    }

    public function delete_meal($id_meal)
    {
        $meal = meals::find($id_meal);
        $meal->delete();
        $date = date_parse_from_format("Y-m-d", $meal->date);
        return redirect()->to('/user/day/' . $date['year'] . '/' . $date['month'] . '/' . $date['day']);
    }

    public function get_create_eaten($id_meal)
    {
        $food = food::all();
        return view('food.create_eaten', ['food' => $food]);
    }

    public function post_create_eaten($id_meal, Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };

        $eaten = new eaten();
        $meal = meals::find($id_meal);

        $eaten->calories = $request->calories;
        $eaten->gramm = $request->gramm;
        $eaten->id_food = $request->id_food;
        $eaten->id_meal = $id_meal; // неизменяемый параметр который из ссылки
        $eaten->save();
        $date = date_parse_from_format("Y-m-d", $meal->date); // потому что в eaten нет даты!!!
        return redirect()->to('/user/day/' . $date['year'] . '/' . $date['month'] . '/' . $date['day']);
    }

    public function get_edit_eaten($id_eaten)
    {
        $food = food::all()->pluck('title', 'id_food'); //ищем виды еды
        $eaten = eaten::find($id_eaten); // ищем итен
        return view('food.edit_eaten', ['food' => $food, 'eaten' => $eaten]);
    }

    public function post_edit_eaten($id_eaten, Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };

        $eaten = eaten::find($id_eaten);
        $eaten->calories = $request->calories;
        $eaten->gramm = $request->gramm;
        $eaten->id_food = $request->id_food;

        $eaten->save();
        return redirect()->to('food/edit_eaten/' . $id_eaten);
    }

    public function delete_eaten($id_eaten)
    {
        $eaten = eaten::find($id_eaten);
        $meal = meals::find($eaten->id_meal); // нашли мил по айди из итена потому что даты нет
        $eaten->delete();
        $date = date_parse_from_format("Y-m-d", $meal->date);
        return redirect()->to('/user/day/' . $date['year'] . '/' . $date['month'] . '/' . $date['day']);
    }

    public function show_eaten($id_meal)
    {
        $meal = Meals::find($id_meal); //нашла мил которому етены принадлежат
        $eaten = eaten::where('id_meal', $id_meal)->with('food')->get();
        return view('food.show_eaten', ['eaten' => $eaten, 'date' => date('Y/n/j', strtotime($meal->date))]);
    }

    public function show_graph_food($date)
    {
        $output['cols'] = array(
            array('id' => '', 'label' => 'Title', 'pattern' => '', 'type' => 'string'),
            array('id' => '', 'label' => 'Count', 'pattern' => '', 'type' => 'number')
        );
        $statsfood = DB::select('select count(id_eaten) as cou_eat, food.title from eaten inner join food on eaten.id_food = food.id_food INNER JOIN meals ON eaten.id_meal = meals.id_meal where month(date) = ? and id_user = ? group by eaten.id_food', [date('n', strtotime($date)), Auth::user()->id]);
        foreach ($statsfood as $food) {
            $output['rows'][] = array('c' => array(array('v' => $food->title, 'f' => null), array('v' => $food->cou_eat, 'f' => null)));
        }
        echo json_encode($output);
    }

    public function vitamins_calculation()
    {
        $sex = Auth::user()->sex; // got sex of user
        $date = date('Y-m-d'); // got current day
        $food = food::all()->keyBy('id_food'); // got all food
        $vitamins = Vitamins::all()->keyBy('id_vitamin'); // got all vitamins
        foreach ($vitamins as &$vitamin) {
            $vitamin->consumed = 0;
        }
        $meals = meals::has('eaten')->where([['date', $date],['id_user', Auth::user()->id]])->with('eaten')->get(); // got meals and eaten in it
        foreach ($meals as $meal) {
           // $meal->eaten; // got our eaten
            foreach ($meal->eaten as $eaten) {
                $vitamins[$food[$eaten->id_food]->id_vitamin]->consumed += $food[$eaten->id_food]->milligrams_vitamin * $eaten->gramm / 100; // count vitamins
            }
        }
        foreach ($vitamins as $vitamin) {
            if ($vitamin['norma_vitamin_' . $sex] <= $vitamin->consumed) { // check sex and got norma
                $vitamin->status = 'success'; // guess what for, Alexander!
            } else {
                $vitamin->status = 'danger'; // this too
            }
        }
        return view('calculation.vitamins', ['vitamins' => $vitamins]);
    }
}
