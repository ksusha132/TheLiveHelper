<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\sets;
use Calendar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Storage;
use DB;
use Validator;
use App\Weight;

class WeightController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'weight' => 'required|max:3',
            'id_weight' => 'required'
        ]);
    }

    public function get_create_weight()
    {
        return view('weight.create_weight'); // transmit into view
    }

    public function post_create_weight($year, $month, $day, Request $request)
    {
        $weight = new weight();
        $weight->weight = $request->weight;
        $weight->date = $year . '-' . $month . '-' . $day;
        $weight->id_user = Auth::user()->id; // юзер который авторизирован
        $weight->save();
        return redirect()->to('/user/day/' . $year . '/' . $month . '/' . $day);
    }

    public function get_edit_weight($id_weight)
    {
        $weight = Weight::find($id_weight);
        return view('weight.edit_weight', ['weight' => $weight, 'date' => date('Y/n/j', strtotime($weight->date))]); // получаю то что есть в базе
    }

    public function post_edit_weight($id_weight, Request $request)
    {
        $weight = weight::find($id_weight); //
        $weight->weight = $request->weight;
        $weight->save();
        return redirect()->to('weight/edit_weight/' . $id_weight);
    }

    public function delete_weight($id_weight)
    {
        $weight = Weight::find($id_weight);
        $weight->delete();
        $date = date_parse_from_format("Y-m-d", $weight->date);
        return redirect()->to('/user/day/' . $date['year'] . '/' . $date['month'] . '/' . $date['day']);
    }

    public function show_graph_weight($date)
    {
        $output['cols'] = array(
            array('id' => '', 'label' => 'Title', 'pattern' => '', 'type' => 'string'),
            array('id' => '', 'label' => 'Weight', 'pattern' => '', 'type' => 'number'),
            array('id' => '', 'label' => 'Desired weight', 'pattern' => '', 'type' => 'number')
        );
        $statsweight = DB::select('select * from weight  where month(date) = ? and id_user = ?  order by date', [date('n', strtotime($date)), Auth::user()->id]);
        foreach ($statsweight as $weight) {
            $output['rows'][] = array('c' => array(array('v' => $weight->date, 'f' => null), array('v' => $weight->weight, 'f' => null),array('v' => Auth::user()->desired_weight, 'f' => null)));
        }
        echo json_encode($output);
    }
}
