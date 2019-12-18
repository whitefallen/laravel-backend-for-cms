<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('token')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('changed_by')->nullable();
            $table->foreign('created_by')->references('id')->on('user')->onDelete('SET NULL');
            $table->foreign('changed_by')->references('id')->on('user')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
