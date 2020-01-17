<?php

namespace App\Listeners;

use App\Events\SavedPost;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendPostEvent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SavedPost  $event
     * @return void
     */
    public function handle(SavedPost $event): void
    {
        $client = new Client();
        $res = $client->get('http://localhost:8001/api/webhook');
        $post = $event->post;
        LOG::critical('sending post data', ['data' => $post->toArray()]);
    }
}
