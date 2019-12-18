<?php

use App\Post;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CMSSeeder extends Seeder
{
    public function run(){
        //clear Database
        DB::table('post')->delete();
        DB::table('user')->delete();

        //standart user erstellen
        $daniel = User::create(array(
            'name' => 'Dany',
            'email' => 'Dany@thomy.de',
            'password' => 'Danyyy'
        ));

        $thomas = User::create(array(
            'name' => 'Thomy',
            'email' => 'thomy@thomy.de',
            'password' => 'thomyyy'
        ));

        $jonas = User::create(array(
            'name' => 'Johnny',
            'email' => 'Johny@thomy.de',
            'password' => 'Johnyyyyy'
        ));

        $this->command->info('Users are ready');

        Post::create(array(
            'title' => 'post1',
            'topic' => [3,4,5],
            'tags' => [1,2,3],
            'published' => true,
            'publish-date' => time(),
            'introduction' => 'dank meme incoming',
            'content' => 'some normie shit, because daniel',
            'image' => 'gay',
            'created_by' => $daniel->id,
            'changed_by' => $daniel->id
        ));

        Post::create(array(
            'title' => 'post2',
            'topic' => '[3,4,5]',
            'tags' => '[1,2,3]',
            'published' => true,
            'publish-date' => time(),
            'introduction' => 'dank meme incoming',
            'content' => 'some not normie shit, because jonas',
            'image' => 'gay',
            'created_by' => $jonas->id,
            'changed_by' => $jonas->id
        ));

        $this->command->info('Posts are ready');


    }
}
