<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicToPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topic_to_post', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('topic_id')->unsigned();
            $table->integer('post_id')->unsigned();
            $table->timestamps();
            $table->foreign('post_id')->references('id')->on('post');
            $table->foreign('topic_id')->references('id')->on('topic');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topic_to_post');
    }
}
