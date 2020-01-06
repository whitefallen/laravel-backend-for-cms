<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $table = 'user';

    protected $fillable = [ 'name','email','password','created_by','changed_by'];


    public function createdPosts(){
        return $this->hasMany(Post::class,'created_by');
    }
    public function editedPosts(){
        return $this->hasMany(Post::class,'changed_by');
    }
    public function createdTags(){
        return $this->hasMany(Tag::class,'created_by');
    }
    public function editedTags(){
        return $this->hasMany(Tag::class,'changed_by');
    }
    public function createdTopics(){
        return $this->hasMany(Topic::class,'created_by');
    }
    public function editedTopics(){
        return $this->hasMany(Topic::class,'changed_by');
    }

    public function createdFormats(){
        return $this->hasMany(Format::class,'created_by');
    }
    public function editedFormats(){
        return $this->hasMany(Format::class,'changed_by');
    }

    /**
     * @inheritDoc
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @inheritDoc
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
