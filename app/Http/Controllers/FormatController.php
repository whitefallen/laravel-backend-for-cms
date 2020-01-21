<?php

namespace App\Http\Controllers;

use App\Models\Format;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Mockery\Exception;

class FormatController extends Controller
{
    public function getAllFormat(){
        return response(array('info' => 1, 'data' => Format::all()));
    }

    public function createFormat(Request $request){
        Format::create(array (
            'name'=>$request['name'],
            'description'=>$request['description'],
            'created_by'=>$request['created_by'],
            'changed_by'=>$request['changed_by']
        ));
        return response(array('info'=>1));
    }

    public function getFormatById(int $id){
        try{
            $format = Format::findOrFail($id);
            $format->creator;
            return response(array('info'=>1,'data' => $format ));
        }catch(ModelNotFoundException $e){
            return response(array('info'=>0,'message'=>'No Format found with provided ID'));
        }catch(Exception $e){
            return response(array('info'=>0,'message'=>$e));
        }
    }

    public function editFormat(Request $request, int $id){
        try{
            Format::where('id',$id)
                ->update([
                    'name'=>$request['name'],
                    'description'=>$request['description'],
                    'created_by'=>$request['created_by'],
                    'changed_by'=>$request['changed_by']
                ]);
            return response(array('info'=>1));
        }catch(ModelNotFoundException $e){
            return response(array('info'=>0,'message'=>'No Format found with provided ID'));
        }catch(Exception $e){
            return response(array('info'=>0,'message'=>$e));
        }
    }

    public function deleteFormat(int $id){
        try{
            $format = Format::findOrFail($id);
            $format->delete();
            return response(array('info' => 1));
        }catch(ModelNotFoundException $e){
            return response(array('info' => 0, 'message' => 'No Format found with provided ID'));
        }catch(Exception $e){
            return response(array('info' => 0, 'message'=>$e));
        }
    }
}
