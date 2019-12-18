<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';

    protected $fillable = [ 'name','email','password','created_by','changed_by'];


    public function posts(){
        return $this->hasMany('post');
    }
}
