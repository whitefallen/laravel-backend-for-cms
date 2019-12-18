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


    protected $fillable = ['title','topic','tags','published','publish-date','introduction','content','image','created_by','changed_by'];
}
