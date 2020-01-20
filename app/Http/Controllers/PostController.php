<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Events\SavedPost;
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

        // get new created post and send it to EventService
        $post = Post::findOrFail($request['title']);
        event(new SavedPost($post));

        return response(array('info'=>1));
    }

    public function getPostById(int $id){
        try{
            $post = Post::findOrFail($id);
            $creator = $post->creator;
            return response(array('info'=>1,'Post' => $post, 'Creator' => $creator));
        }catch(ModelNotFoundException $e){
            return response(array('info'=>0,'message'=>'No Post found with provided ID'));
        }catch(Exception $e){
            return response(array('info'=>0,'message'=>$e));
        }
    }

    public function editPost(Request $request, int $id){
        try{
            Post::where('id',$id)
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

            // get new edited post and send it to EventService
            $post = Post::findOrFail($id);
            event(new SavedPost($post));

            return response(array('info'=>1));
        }catch(ModelNotFoundException $e){
            return response(array('info' => 0,'message' => 'No User found'));
        }catch(Exception $e){
            return response(array('info' => 0,'message' => $e));
        }
    }

    public function deletePost(int $id){
        try{
            $post = Post::findOrFail($id);
            $post->delete();
            return response(array('info' => 1));
        }catch(ModelNotFoundException $e){
            return response(array('info' => 0, 'message' => 'No Post found with provided ID'));
        }catch(Exception $e){
            return response(array('info' => 0, 'message'=>$e));
        }
    }

    public function getPostsFromUser(int $id){
        $posts = User::find($id)->posts;
        return response(array('info'=>1,'post'=>$posts));
    }
}
