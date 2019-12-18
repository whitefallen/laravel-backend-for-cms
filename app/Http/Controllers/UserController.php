<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function insertUser(Request $request){
        User::create(array(
            'name' => $request['username'],
            'email' => $request['email'],
            'password' => $request['password']
        ));

        return response(array('info'=>1));
    }

    public function getAllUser(){
        $users = User::all();

        return $users;
    }
}
