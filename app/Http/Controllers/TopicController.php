<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Resources\WebhookEventOptions;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Mockery\Exception;

class TopicController extends Controller
{
    public function getAllTopic(){
        return response(array('info' => 1, 'data' => Topic::all()));
    }

    public function createTopic(Request $request){

        $imagePath = 'storage/topicImages/placeholder-800x600.jpg';

        if(isset($request['image']) && !empty($request['image'])){
            $image = $request['image'];
            $imagePath = $this->processBase64String($image, 'topic');
        }
        $topic = Topic::create(array(
            'name'=>$request['name'],
            'description'=>$request['description'],
            'image'=>$imagePath,
            'created_by'=>$request['created_by'],
            'changed_by'=>$request['changed_by']
        ));

        $this->fireEvent(WebhookEventOptions::getOptions()['newTopic'], $topic);

        return response(array('info'=>1));
    }

    public function getTopicById(int $id){
        try{
            $topic = Topic::findOrFail($id);
            $topic->creator;
            $topic->editor;
            return response(array('info'=>1,'data' => $topic ));
        }catch(ModelNotFoundException $e){
            return response(array('info'=>0,'message'=>'No Topic found with provided ID'));
        }catch(Exception $e){
            return response(array('info'=>0,'message'=>$e));
        }
    }

    public function editTopic(Request $request, int $id){

        if(isset($request['image']) && !empty($request['image']) && $request['imgIsSet'] === true){
            $image = $request['image'];
            $imagePath = $this->processBase64String($image, 'topic');
        }else{
            $topic = Topic::findOrFail($id);
            $imagePath = $topic->image;
        }
        try{
            Topic::where('id',$id)
                ->update([
                    'name'=>$request['name'],
                    'description'=>$request['description'],
                    'image'=>$imagePath,
                    'created_by'=>$request['created_by'],
                    'changed_by'=>$request['changed_by']
                ]);

            $topic = Topic::findOrFail($id);

            $this->fireEvent(WebhookEventOptions::getOptions()['changedTopic'], $topic);

            return response(array('info'=>1, 'data' => $topic));
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
