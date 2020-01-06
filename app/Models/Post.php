<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'post';

    protected $casts = [
        'topic' => 'array',
        'tags' => 'array'
    ];

    protected $fillable = ['title','topic','tags','format','published','publish-date','introduction','content','image','created_by','changed_by'];

    public function format(){
        return $this->belongsTo(Format::class, 'format');
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor() {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public function topics(){
        return $this->belongsToMany(Topic::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
