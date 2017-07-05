<?php

namespace App\Http\Controllers;

use App\meals;
use App\type_of_sleep;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\sets;
use Calendar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Storage;
use App\sleep;
use DB;
use Validator;

class SleepController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'time_start_sleep' => 'required|max:5|date_format:H:i',
            'time_end_sleep' => 'required|max:5|date_format:H:i',
            'pleasure' => 'required|max:3',
            'id_type_of_sleep' => 'required'
        ]);
    }

    public function get_create_sleep()
    {
        $type_of_sleep = type_of_sleep::all();
        return view('sleep.create_sleep', ['type_of_sleep' => $type_of_sleep]); // получаю все типы сна и передаю их в вид
    }

    public function post_create_sleep($year, $month, $day, Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };

        $sleep = new sleep();

        $sleep->time_start_sleep = $request->time_start_sleep;
        $sleep->time_end_sleep = $request->time_end_sleep;
        $sleep->pleasure = $request->pleasure;
        $sleep->date = $year . '-' . $month . '-' . $day;
        $sleep->id_type_of_sleep = $request->id_type_of_sleep; //  типы сна
        $sleep->id_user = Auth::user()->id; // юзер который авторизирован
        $sleep->save();
        return redirect()->to('/user/day/' . $year . '/' . $month . '/' . $day);
    }

    public function get_edit_sleep($id_sleep)
    {
        $sleep = sleep::find($id_sleep);
        $type_of_sleep = type_of_sleep::all()->pluck('sleep_name', 'id_type_of_sleep');
        return view('sleep.edit_sleep', ['sleep' => $sleep, 'type_of_sleep' => $type_of_sleep, 'date' => date('Y/n/j',strtotime($sleep->date))]); // получаю то что есть в базе

    }

    public function post_edit_sleep($id_sleep, Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };

        $sleep = sleep::find($id_sleep); //
        $sleep->time_start_sleep = $request->time_start_sleep;
        $sleep->time_end_sleep = $request->time_end_sleep;
        $sleep->pleasure = $request->pleasure;
        $sleep->id_type_of_sleep = $request->id_type_of_sleep;

        $sleep->save();
        return redirect()->to('sleep/edit_sleep/' . $id_sleep);
    }

    public function delete_sleep($id_sleep)
    {
        $sleep = sleep::find($id_sleep);
        $sleep->delete();
        $date = date_parse_from_format("Y-m-d", $sleep->date);
        return redirect()->to('/user/day/' . $date['year'] . '/' . $date['month'] . '/' . $date['day']);
    }

    public function show_graph_sleep($date)
    {
        $output['cols'] = array(
            array('id' => '', 'label' => 'Title', 'pattern' => '', 'type' => 'string'),
            array('id' => '', 'label' => 'Count', 'pattern' => '', 'type' => 'number')
        );
        $statsleep = DB::select('select count(id_sleep) as cou_sl, type_of_sleep.sleep_name from sleep inner join type_of_sleep on sleep.id_type_of_sleep = type_of_sleep.id_type_of_sleep where month(date) = ? and id_user = ? group by sleep.id_type_of_sleep', [date('n', strtotime($date)), Auth::user()->id]);
        foreach ($statsleep as $sleep) {
            $output['rows'][] = array('c' => array(array('v' => $sleep->sleep_name, 'f' => null), array('v' => $sleep->cou_sl, 'f' => null)));
        }
        echo json_encode($output);
    }
}
