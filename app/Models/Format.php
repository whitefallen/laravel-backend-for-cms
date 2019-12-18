<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    protected $table = 'format';

    protected $fillable = ['name','description','created_by','changed_by'];
}
