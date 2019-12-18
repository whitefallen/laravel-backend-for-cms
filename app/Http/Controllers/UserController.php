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

    public function deleteUser(int $id){
        $user = User::find($id);
        if(!($user == null)){
            $user->delete();
            return response(array('info' => 1));
        }else{
            return response(array('info' => 0, 'message' => 'No User found with provided ID'));
        }
    }

    public function getUserById(int $id){
        $user = User::find($id);
        if($user != null){
            return response(array('info' => 1, 'User' => $user));
        }else{
            return response(array('info' => 0, 'message' => 'No User found with provided ID'));
        }

    }

    public function getAllUser(){
        return response(array('info' => 1, 'Users' => User::all()));
    }

    public function editUser(Request $request){
        if(User::find($request['id']) != null){
            User::where('id',$request['id'])
                ->update([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => $request['password']
                ]);
            return response(array('info'=>1));
        }else{
            return response(array('info' => 0,'message' => 'No User found'));
        }
    }
}
