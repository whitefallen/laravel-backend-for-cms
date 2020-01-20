<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Topic;
use App\Models\Tag;
use App\Models\User;
use App\Events\SavedPost;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class PostController extends Controller
{
    public function getAllPost(){
        return response(array('info' => 1, 'data' => Post::all()));
    }

    public function createPost(Request $request){
        $post = Post::create(array(
            'title'=>$request['title'],
            'format_id'=>$request['format_id'],
            'published'=>$request['published'],
            'publish_date'=>$request['publish_date'],
            'introduction'=>$request['introduction'],
            'content'=>$request['content'],
            'image'=>$request['image'],
            'created_by'=>$request['created_by'],
            'changed_by'=>$request['changed_by']
        ));

        /**
         * Set dependencies
         */
        $tags = $request['tags'];
        $topics = $request['topic'];
        $format = $request['format_id'];

        $post->tags()->sync($tags);
        $post->topics()->sync($topics);
        $post->format()->associate($format);

        // Fire event to trigger webhooks
        try {
            event(new SavedPost($post));
        } catch (\Exception $e) {
            LOG::Warning('No API Server online');
        }


        return response(array('info'=>1, 'Post' => $post));
    }

    public function getPostById(int $id){
        try{
            $post = Post::findOrFail($id);
            $creator = $post->creator;
            return response(array('info'=>1,'data' => $post, 'creator' => $creator));
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
                    'format_id' => $request['format_id'],
                    'published' => $request['published'],
                    'publish_date' => $request['publish_date'],
                    'introduction' => $request['introduction'],
                    'content' => $request['content'],
                    'image' => $request['image'],
                    'created_by' => $request['created_by'],
                    'changed_by' => $request['changed_by']
                ]);

            $tags = $request['tags'];
            $topics = $request['topic'];
            $format = $request['format_id'];

            $post = Post::findOrFail($id);

            $post->tags()->sync($tags);
            $post->topics()->sync($topics);
            $post->format()->associate($format);

            // Fire event to trigger webhooks
            try {
                event(new SavedPost($post));
            } catch (\Exception $e) {
                LOG::Warning('No API Server online');
            }

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
