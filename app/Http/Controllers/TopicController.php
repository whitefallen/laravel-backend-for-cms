<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;

class TopicController extends Controller
{
    public function getAllTopic(){
        return response(array('info' => 1, 'data' => Topic::all()));
    }

    public function createTopic(Request $request){

        $imagePath = 'storage/topicImages/default-image-800x600.jpg';

        if(isset($request['image']) && !empty($request['image'])){
            $image = $request['image'];
            $imagePath = $this->processBase64String($image);
        }
        Topic::create(array(
            'name'=>$request['name'],
            'description'=>$request['description'],
            'image'=>$imagePath,
            'created_by'=>$request['created_by'],
            'changed_by'=>$request['changed_by']
        ));
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

        if(isset($request['image']) && !empty($request['image']) && $request['imgIsSet'] == true){
            $image = $request['image'];
            $imagePath = $this->processBase64String($image);
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

    private function getImageExtensionFromBase64(string $imageString) : string {
        $extension = '';
        $substring_start = strpos($imageString, 'data:image/');
        $substring_start += strlen('data:image/');
        $size = strpos($imageString, ';base64', $substring_start) - $substring_start;
        $extension = substr($imageString, $substring_start, $size);
        Log::info('Image extension is', ['extension' => $extension]);
        return $extension;
    }

    private function getImageDataStringFromBase64(string $imageString): string {
        $substring_start = strpos($imageString, ';base64');
        $substring_start += strlen(';base64');
        $data = substr($imageString, $substring_start);
        Log::info('Image data is', ['extension' => $data]);
        return $data;
    }

    private function processBase64String($image): string
    {
        $imagePath = '';
        if (preg_match('/^data:image\/(\w+);base64,/', $image)) {
            $extension = $this->getImageExtensionFromBase64($image);
            $imgData = $this->getImageDataStringFromBase64($image);
            $img = base64_decode($imgData);
            $imguid = uniqid('img_', true);
            $imgName = $imguid .'.'.$extension;
            Storage::disk('public')->put('/topicImages/'.$imgName, $img);
            $imagePath = 'storage/topicImages/'.$imgName;
            return $imagePath;
        }
    }
}
