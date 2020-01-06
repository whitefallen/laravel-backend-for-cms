<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    protected $table = 'format';

    protected $fillable = ['name','description','created_by','changed_by'];

    public function posts(){
        return $this->hasMany(Post::class,'format');
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor() {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
