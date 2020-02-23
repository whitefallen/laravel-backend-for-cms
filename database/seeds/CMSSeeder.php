<?php

use App\Models\Format;
use App\Models\Tag;
use App\Models\Topic;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CMSSeeder extends Seeder
{
    public function run(){
        //clear Database
        DB::table('post')->delete();
        DB::table('topic')->delete();
        DB::table('tag')->delete();
        DB::table('format')->delete();
        DB::table('user')->delete();

        $daniel = User::create(array(
            'name' => 'Dany',
            'email' => 'Dany@thomy.de',
            'password' => Hash::make('Danyyy')
        ));

        $thomas = User::create(array(
            'name' => 'Thomy',
            'email' => 'thomy@thomy.de',
            'password' => Hash::make('thomyyy')
        ));

        $jonas = User::create(array(
            'name' => 'Johnny',
            'email' => 'jonasbaur@hotmail.de',
            'password' => Hash::make('test')
        ));

        $this->command->info('Users are ready');

        $switch = Topic::create(array(
            'name' => 'Nintendo Switch',
            'description' => 'Nintendo newest Console',
            'image' => 'storage/topicImages/switch.jpg',
            'created_by' => $daniel->id,
            'changed_by' => $jonas->id
        ));

        $pc = Topic::create(array(
            'name' => 'PC',
            'description' => 'Elite Gaming',
            'image' => 'storage/topicImages/pc.png',
            'created_by' => $thomas->id,
            'changed_by' => $thomas->id
        ));

        $ps4 = Topic::create(array(
            'name' => 'PS4',
            'description' => 'Exclusive Game Home',
            'image' => 'storage/topicImages/ps4.png',
            'created_by' => $jonas->id,
            'changed_by' => $daniel->id
        ));

        $this->command->info('Topics are ready');

        $review = Format::create(array(
            'name' => 'Review',
            'description' => 'Written Opinion',
            'created_by' => $jonas->id,
            'changed_by' => $daniel->id
        ));

        $podcast = Format::create(array(
            'name' => 'Podcast',
            'description' => 'Daniel und Jonas bashen sich',
            'created_by' => $jonas->id,
            'changed_by' => $daniel->id
        ));

        $this->command->info('Formats are ready');

        $godofwar = Tag::create(array(
            'name' => 'godofwar',
            'description' => 'God of War',
            'created_by' => $jonas->id,
            'changed_by' => $daniel->id
        ));

        $bloodstained = Tag::create(array(
            'name' => 'bloodstained',
            'description' => 'Bloodstained Game',
            'created_by' => $jonas->id,
            'changed_by' => $jonas->id
        ));

        $this->command->info('Tags are ready');

        // 'topic' => [$ps4->id,$switch->id,$pc->id],
        // 'tags' => [$bloodstained->id, $godofwar->id],
        // 'format' => $review->id,
        $post1 = Post::create(array(
            'title' => 'post1',
            'published' => true,
            'publish_date' => new DateTime(),
            'introduction' => 'dank meme incoming',
            'content' => 'some normie shit, because daniel',
            'image' => 'storage/postImages/default-image-800x600.jpg',
            'created_by' => $daniel->id,
            'changed_by' => $daniel->id
        ));

        // 'topic' => [$ps4->id,$switch->id,$pc->id],
        // 'tags' => [$bloodstained->id],
        // 'format' => $podcast->id,
        $post2 = Post::create(array(
            'title' => 'post2',
            'published' => true,
            'publish_date' => new DateTime(),
            'introduction' => 'dank meme incoming',
            'content' => 'some not normie shit, because jonas',
            'image' => 'storage/postImages/default-image-800x600.jpg',
            'created_by' => $jonas->id,
            'changed_by' => $jonas->id
        ));

        //example of associate a post to a format
        $post1->format()->associate($review);
        $post1->save();

        // example of saving post to a format
        $podcast->posts()->save($post2);

        // example of attaching tags to posts
        $post1->tags()->attach($bloodstained);
        $post1->tags()->attach($godofwar);

        // example of attaching posts to tags
        $bloodstained->posts()->attach($post2);

        // example of attaching posts to topics
        $ps4->posts()->attach($post1);
        $ps4->posts()->attach($post2);

        // example of attaching posts to topics
        $pc->posts()->attach($post1);
        $pc->posts()->attach($post2);

        // example of attaching posts to topics
        $switch->posts()->attach($post1);
        $switch->posts()->attach($post2);


        $this->command->info('Posts are ready');


    }
}
