<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'post';

    protected $casts = [
        'topic' => 'array',
        'tags' => 'array'
    ];

    protected $fillable = ['title','topic','tags','format','published','publish-date','introduction','content','image','created_by','changed_by'];

    public function formats(){
        return $this->belongsTo('Format');
    }

    public function topics(){
        return $this->belongsToMany('Topic');
    }

    public function tags(){
        return $this->belongsToMany('Tag');
    }
}
