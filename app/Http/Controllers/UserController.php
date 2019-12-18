<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function insertUser(){
        //TODO code body
    }

    public function getAllUser(){
        $users = User::all();

        return $users;
    }
}
