<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Mockery\Exception;

class TopicController extends Controller
{
    public function getAllTopic(){
        return response(array('info' => 1, 'data' => Topic::all()));
    }

    public function createTopic(Request $request){
        if(isset($request['image']) && !empty($request['image'])){
            /*
            request()->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            */
            $imageName = time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('topicImages'), $imageName);
            $imagePath = 'storage/topicImages/' . $imageName;
        }else{
            $imagePath = 'storage/topicImages/default-image-800x600.jpg';
        }
        Topic::create(array(
            'name'=>$request['name'],
            'description'=>$request['description'],
            'image'=>$request[$imagePath],
            'created_by'=>$request['created_by'],
            'changed_by'=>$request['changed_by']
        ));
        return response(array('info'=>1, 'debug' => $request['image']));
    }

    public function getTopicById(int $id){
        try{
            $topic = Topic::findOrFail($id);
            return response(array('info'=>1,'data' => $topic ));
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
