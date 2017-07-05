<?php

namespace App\Http\Controllers;


use Calendar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Storage;
use App\type_trains;
use App\trains;
use App\meals;
use App\sleep;
use App\Role;

class AdminController extends Controller
{
    public function main()
    {

    }

    public function Show_Users()
    {
        $users = User::all();
        return view('admin.show_users', ['users' => $users]);
    }

    public function Save_Roles(Request $request)
    {
        $user = User::where('email', $request['email'])->first();
        $user->roles()->detach();// отсоединем все роли
        if($request['role_user']){
            $user->roles()->attach(Role::where('name','User')->first());
        }
        if($request['role_trainer']){
            $user->roles()->attach(Role::where('name','Trainer')->first());
        }
        if($request['role_admin']){
            $user->roles()->attach(Role::where('name','Admin')->first());
        }
        return redirect()->back();
    }
}
