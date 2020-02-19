<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    protected $table = 'webhooks';

    protected $fillable = ['url','event'];

    protected $casts = [
        'event' => 'array',
    ];

}
