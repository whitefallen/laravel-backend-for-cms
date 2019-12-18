<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Mockery\Exception;


class UserController extends Controller
{
    public function createUser(Request $request){
        User::create(array(
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password']
        ));

        return response(array('info'=>1));
    }

    public function deleteUser(int $id){
        try{
            $user = User::findOrFail($id);
            $user->delete();
            return response(array('info' => 1));
        }catch(ModelNotFoundException $e){
            return response(array('info' => 0, 'message' => 'No User found with provided ID'));
        }catch(Exception $e){
            return response(array('info' => 0, 'message'=>$e));
        }
    }

    public function getUserById(int $id){
        try{
            $user = User::findOrFail($id);
            return response(array('info' => 1, 'User' => $user));
        }catch(ModelNotFoundException $e){
            return response(array('info' => 0, 'message' => 'No User found with provided ID'));
        }catch(Exception $e){
            return response(array('info' => 0, 'message'=>$e));
        }
    }

    public function getAllUser(){
        return response(array('info' => 1, 'Users' => User::all()));
    }

    public function editUser(Request $request){
        try{
            User::where('id',$request['id'])
                ->update([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => $request['password']
                ]);
            return response(array('info'=>1));
        }catch(ModelNotFoundException $e){
            return response(array('info' => 0,'message' => 'No User found'));
        }catch(Exception $e){
            return response(array('info' => 0,'message' => $e));
        }
    }
}
