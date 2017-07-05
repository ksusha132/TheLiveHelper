<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Analis_results;
use App\Analis;
use App\User;
use Illuminate\Support\Facades\Auth;

class AnalisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_create_analis()
    {
        $Analis = Analis::all(); // get all analis
        return view('user.create_analis', ['Analis' => $Analis]); // transmit into view
    }

    public function post_create_analis(Request $request)
    {
        $analis_results = new Analis_results; // create new analis
        $analis_results->id_user = Auth::User()->id; // id logged user
        $analis_results->id_analis = $request->id_analis; // get id_analis from request
        $analis_results->input_user_analis = $request->input_user_analis; // input user id from request too
        $analis_results->save();
        return redirect()->back();
    }

    public function get_show_analis()
    {
        $analis_results = Analis_results::where('id_user', Auth::user()->id)->with('Analis')->get(); // take analises from auth user
        $analises = Analis::all();
        return view('user.show_analis', ['analis_results' => $analis_results, 'analises' => $analises]);
    }

    public function post_show_analis(Request $request)
    {
        $cur_data = date('Y-m-d');
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        if (empty($date_from) && empty($date_to)) {
            $analis_results = Analis_results::where('id_user', Auth::user()->id)->with('Analis')->get();
        } elseif (empty($date_from)) {
            echo 'Invalid data. Check your request!';
        } elseif (empty($date_to)) {
            $analis_results = Analis_results::where('id_user', Auth::user()->id)->with('Analis')->where([['created_at','<=',date("Y-m-d",strtotime($cur_data."+1 day"))],['created_at','>=',$date_from]])->get();
        } else {
            $analis_results = Analis_results::where('id_user', Auth::user()->id)->with('Analis')->where([['created_at','<=',date("Y-m-d",strtotime($date_to."+1 day"))],['created_at','>=',$date_from]])->get();
        }
        // take analises from auth user
        $analises = Analis::all();
        return view('user.show_analis', ['analis_results' => $analis_results, 'analises' => $analises, 'date_from' => $request->date_from, 'date_to' => $request->date_to]);
    }

    public function get_edit_analis($id_results)
    {
        $analis_result = Analis_results::find($id_results); // get our results
        $analis = Analis::pluck('name_analis', 'id_analis'); // get our analises names
        return view('user.edit_analis', ['analis_result' => $analis_result, 'analis' => $analis]);
    }

    public function post_edit_analis(Request $request, $id_results)
    {
        $analis_result = Analis_results::find($id_results);

        $analis_result->input_user_analis = $request->input_user_analis;
        $analis_result->id_analis = $request->id_analis;
        $analis_result->save();
        return redirect()->back();
    }

    public function Delete_analis($id_results)
    {
        $analis_result = Analis_results::find($id_results);
        $analis_result->delete();
        return redirect()->back();
    }

    public function draw_graph($id_analis, $date_from = null, $date_to = null)
    {
        $cur_data = date('Y-m-d');
        $output['cols'] = array(
            array('id' => '', 'label' => 'Title', 'pattern' => '', 'type' => 'string'),
            array('id' => '', 'label' => 'Analis', 'pattern' => '', 'type' => 'number')
        );
        if (empty($date_from) && empty($date_to)) {
            $analises = Analis::with(['analis_results' => function ($query) {
                $query->where('id_user', Auth::user()->id);
            }])->where('id_analis', $id_analis)->first();
        } elseif (empty($date_from)) {
            //  echo 'Invalid data. Check your request!';
        } elseif (empty($date_to)) {
            $analises = Analis::with(['analis_results' => function ($query) use ($date_from, $cur_data) {
                $query->where([['id_user', Auth::user()->id],['created_at','<=',date("Y-m-d",strtotime($cur_data."+1 day"))],['created_at','>=',$date_from]]);
            }])->where('id_analis', $id_analis)->first();
        } else {
            $analises = Analis::with(['analis_results' => function ($query) use ($date_from, $date_to) {
                $query->where([['id_user', Auth::user()->id],['created_at','<=',date("Y-m-d",strtotime($date_to."+1 day"))],['created_at','>=',$date_from]]);
            }])->where('id_analis', $id_analis)->first();
        }

        foreach ($analises->analis_results as $analis_res) {

            $output['rows'][] = array('c' => array(array('v' => $analises->name_analis, 'f' => null), array('v' => $analis_res->input_user_analis, 'f' => null)));
        }
        echo json_encode($output);
    }


}


