<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'topic';

    protected $fillable = ['name','description','image','created_by','changed_by'];

    public function posts(){
        return $this->belongsToMany(Post::class, 'topic_to_post', 'topic_id', 'post_id')->withTimestamps();
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor() {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
