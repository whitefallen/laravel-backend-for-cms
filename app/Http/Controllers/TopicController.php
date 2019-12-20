<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Mockery\Exception;

class TopicController extends Controller
{
    public function getAllTopic(){
        return response(array('info' => 1, 'Topics' => Topic::all()));
    }

    public function createTopic(Request $request){
        Topic::create(array(
            'name'=>$request['name'],
            'description'=>$request['description'],
            'image'=>$request['image'],
            'created_by'=>$request['created_by'],
            'changed_by'=>$request['changed_by']
        ));
        return response(array('info'=>1));
    }

    public function getTopicById(int $id){
        try{
            $topic = Topic::findOrFail($id);
            return response(array('info'=>1,'Topic' => $topic ));
        }catch(ModelNotFoundException $e){
            return response(array('info'=>0,'message'=>'No Topic found with provided ID'));
        }catch(Exception $e){
            return response(array('info'=>0,'message'=>$e));
        }
    }

    public function editTopic(Request $request, int $id){
        try{
            Topic::where('id',$id)
                ->update([
                    'name'=>$request['name'],
                    'description'=>$request['description'],
                    'image'=>$request['image'],
                    'created_by'=>$request['created_by'],
                    'changed_by'=>$request['changed_by']
                ]);
            return response(array('info'=>1));
        }catch(ModelNotFoundException $e){
            return response(array('info'=>0,'message'=>'No Topic found with provided ID'));
        }catch(Exception $e){
            return response(array('info'=>0,'message'=>$e));
        }
    }

    public function deleteTopic(int $id){
        try{
            $topic = Topic::findOrFail($id);
            $topic->delete();
            return response(array('info'=>1));
        }catch(ModelNotFoundException $e){
            return response(array('info'=>0,'message'=>'No Topic found with provided ID'));
        }catch(Exception $e){
            return response(array('info'=>0,'message'=>$e));
        }
    }
}
