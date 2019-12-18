<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Mockery\Exception;

class PostController extends Controller
{
    public function getAllPost(){
        return response(array('info' => 1, 'Posts' => Post::all()));
    }

    public function createPost(Request $request){
        Post::create(array(
            'title'=>$request['title'],
            'topic'=>$request['topic'],
            'tags'=>$request['tags'],
            'format'=>$request['format'],
            'published'=>$request['published'],
            'publish-date'=>$request['publish-date'],
            'introduction'=>$request['introduction'],
            'content'=>$request['content'],
            'image'=>$request['image'],
            'created_by'=>$request['created_by'],
            'changed_by'=>$request['changed_by']
        ));
        return response(array('info'=>1));
    }

    public function getPostById(int $id){
        try{
            $post = Post::findOrFail($id);
            return response(array('info'=>1,'Post' => $post ));
        }catch(ModelNotFoundException $e){
            return response(array('info'=>0,'message'=>'No Post found with provided ID'));
        }catch(Exception $e){
            return response(array('info'=>0,'message'=>$e));
        }
    }

    public function editPost(Request $request){
        try{
            Post::where('id',$request['id'])
                ->update([
                    'title' => $request['title'],
                    'topic' => $request['topic'],
                    'tags' => $request['tags'],
                    'format' => $request['format'],
                    'published' => $request['published'],
                    'publish-date' => $request['publish-date'],
                    'introduction' => $request['introduction'],
                    'content' => $request['content'],
                    'image' => $request['image'],
                    'created_by' => $request['created_by'],
                    'changed_by' => $request['changed_by']
                ]);
            return response(array('info'=>1));
        }catch(ModelNotFoundException $e){
            return response(array('info' => 0,'message' => 'No User found'));
        }catch(Exception $e){
            return response(array('info' => 0,'message' => $e));
        }
    }
}
