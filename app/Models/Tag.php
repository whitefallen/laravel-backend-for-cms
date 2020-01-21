<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tag';

    protected $fillable = ['name','description','created_by','changed_by'];

    public function posts(){
        return $this->belongsToMany(Post::class, 'tag_to_post', 'tag_id', 'post_id')->withTimestamps();
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor() {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
