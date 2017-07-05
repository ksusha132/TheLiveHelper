<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Storage;
use App\type_trains;
use App\trains;
use App\meals;
use App\sleep;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trains = trains::where([['date', date('Y') . '-' . date('m') . '-' . date('d')], ['id_user', Auth::user()->id]])->get();
        $trains->each(function ($train) {
            $train->timestart = date('H:i', strtotime($train->timestart));
            $train->timeend = date('H:i', strtotime($train->timeend));
        });

        return view('home',['trains' => $trains] );
    }
}
