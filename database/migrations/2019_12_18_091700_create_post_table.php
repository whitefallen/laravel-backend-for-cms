<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->json('topic')->nullable();
            $table->json('tags')->nullable();
            $table->integer('format_id')->nullable();
            $table->boolean('published');
            $table->date('publish_date')->nullable();
            $table->text('introduction');
            $table->text('content');
            $table->string('image');
            $table->integer('created_by');
            $table->integer('changed_by')->nullable();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('user')->onDelete('CASCADE');
            $table->foreign('changed_by')->references('id')->on('user')->onDelete('SET NULL');
            $table->foreign('format_id')->references('id')->on('format')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post');
    }
}
