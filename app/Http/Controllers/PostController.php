<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Resources\WebhookEventOptions;
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

        $imagePath = 'storage/postImages/placeholder-800x600.jpg';

        if(isset($request['image']) && !empty($request['image'])){
            $image = $request['image'];
            $imagePath = $this->processBase64String($image, 'post');
        }
        if(isset($request['publish_date'])) {
            $publish_date = new \DateTime();
            $publish_date->setTimestamp($request['publish_date']);
        } else {
            $publish_date = null;
        }
        $post = Post::create(array(
            'title'=>$request['title'],
            'published'=>$request['published'],
            'publish_date'=>$publish_date,
            'introduction'=>$request['introduction'],
            'content'=>$request['content'],
            'image'=>$imagePath,
            'created_by'=>$request['created_by'],
            'changed_by'=>$request['changed_by']
        ));

        /**
         * Set dependencies
         */
        $tags = $request['tags'];
        $topics = $request['topics'];
        $format = $request['format_id'];

        $post->tags()->sync($tags);
        $post->topics()->sync($topics);
        $post->format()->associate($format);
        $post->save();

        $this->fireEvent(WebhookEventOptions::getOptions()['newPost'], $post);

        return response(array('info'=>1, 'Post' => $post));
    }

    public function getPostById(int $id){
        try{
            $post = Post::findOrFail($id);
            $post->creator;
            $post->editor;
            $post->tags;
            $post->topics;
            $post->format;
            return response(array('info'=>1,'data' => $post));
        }catch(ModelNotFoundException $e){
            return response(array('info'=>0,'message'=>'No Post found with provided ID'));
        }catch(Exception $e){
            return response(array('info'=>0,'message'=>$e));
        }
    }

    public function editPost(Request $request, int $id){
        if(isset($request['image']) && !empty($request['image']) && $request['imgIsSet'] === true){
            $image = $request['image'];
            $imagePath = $this->processBase64String($image, 'post');
        }else{
            $post = Post::findOrFail($id);
            LOG::Info('Image not set', ['data' => $request['image'], 'operation' => $request['imgIsSet']]);
            $imagePath = $post->image;
        }
        if(isset($request['publish_date'])) {
            $publish_date = new \DateTime();
            $publish_date->setTimestamp($request['publish_date']);
        } else {
            $publish_date = null;
        }
        try{
            Post::where('id',$id)
                ->update([
                    'title' => $request['title'],
                    'published' => $request['published'],
                    'publish_date' => $publish_date,
                    'introduction' => $request['introduction'],
                    'content' => $request['content'],
                    'image' => $imagePath,
                    'created_by' => $request['created_by'],
                    'changed_by' => $request['changed_by']
                ]);

            $tags = $request['tags'];
            $topics = $request['topics'];
            $format = $request['format_id'];

            $post = Post::findOrFail($id);

            $post->tags()->sync($tags);
            $post->topics()->sync($topics);
            $post->format()->associate($format);
            $post->save();

            // Fire event to trigger webhooks
            $this->fireEvent(WebhookEventOptions::getOptions()['changedPost'], $post);

            return response(array('info'=>1, 'data'=> $post));
        }catch(ModelNotFoundException $e){
            return response(array('info' => 0,'message' => 'No User found'));
        }catch(Exception $e){
            return response(array('info' => 0,'message' => $e));
        }
    }

    public function deletePost(int $id){
        try{
            $post = Post::findOrFail($id);
            $post->tags()->detach();
            $post->topics()->detach();
            $post->delete();
            return response(array('info' => 1, 'message' => 'Post successfully deleted'));
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
