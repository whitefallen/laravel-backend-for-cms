<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Mockery\Exception;

class TagController extends Controller
{
    public function getAllTag(){
        return response(array('info' => 1, 'data' => Tag::all()));
    }

    public function createTag(Request $request){
        $tag = Tag::create(array(
            'name'=>$request['name'],
            'description'=>$request['description'],
            'created_by'=>$request['created_by'],
            'changed_by'=>$request['changed_by']
        ));

        $this->fireEvent(SavedTag::class, $tag);

        return response(array('info'=>1));
    }

    public function getTagById(int $id){
        try{
            $tag = Tag::findOrFail($id);
            $tag->creator;
            $tag->editor;
            return response(array('info'=>1,'data' => $tag ));
        }catch(ModelNotFoundException $e){
            return response(array('info'=>0,'message'=>'No Tag found with provided ID'));
        }catch(Exception $e){
            return response(array('info'=>0,'message'=>$e));
        }
    }

    public function editTag(Request $request,int $id){
        try{
            Tag::where('id',$id)
                ->update([
                    'name'=>$request['name'],
                    'description'=>$request['description'],
                    'created_by'=>$request['created_by'],
                    'changed_by'=>$request['changed_by']
                ]);

            $tag = Tag::findOrFail($id);
            $this->fireEvent(SavedTag::class, $tag);

            return response(array('info'=>1));
        }catch(ModelNotFoundException $e){
            return response(array('info'=>0,'message'=>'No Tag found with provided ID'));
        }catch(Exception $e){
            return response(array('info'=>0,'message'=>$e));
        }
    }

    public function deleteTag(int $id){
        try{
            $tag = Tag::findOrFail($id);
            $tag->delete();
            return response(array('info'=>1));
        }catch(ModelNotFoundException $e){
            return response(array('info'=>0,'message'=>'No Tag found with provided ID'));
        }catch(Exception $e){
            return response(array('info'=>0,'message'=>$e));
        }
    }
}
