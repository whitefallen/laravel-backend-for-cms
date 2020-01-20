<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;


class UserController extends Controller
{
    public function createUser(Request $request)
    {
        User::create(array(
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ));

        return response(array('info' => 1));
    }

    public function deleteUser(int $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response(array('info' => 1));
        } catch (ModelNotFoundException $e) {
            return response(array('info' => 0, 'message' => 'No User found with provided ID'));
        } catch (Exception $e) {
            return response(array('info' => 0, 'message' => $e));
        }
    }

    public function getUserById(int $id)
    {
        try {
            $user = User::findOrFail($id);
            return response(array('info' => 1, 'data' => $user));
        } catch (ModelNotFoundException $e) {
            return response(array('info' => 0, 'message' => 'No User found with provided ID'));
        } catch (Exception $e) {
            return response(array('info' => 0, 'message' => $e));
        }
    }

    public function getAllUser()
    {
        return response(array('info' => 1, 'data' => User::all()));
    }

    public function editUser(Request $request, int $id)
    {
        try {
            User::where('id', $id)
                ->update([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => $request['password']
                ]);
            return response(array('info' => 1));
        } catch (ModelNotFoundException $e) {
            return response(array('info' => 0, 'message' => 'No User found'));
        } catch (Exception $e) {
            return response(array('info' => 0, 'message' => $e));
        }
    }

    public function login(Request $request){
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['info'=>0,'error' => 'invalid_credentials']);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['info'=>0,'error' => 'could_not_create_token']);
        }

        // all good so return the token
        return response()->json(['info'=>1,'token' => $token]);

    }

}
