<?php

namespace App\Listeners;

use App\Events\SavedPost;
use App\Models\Webhook;
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
        $webhooks = Webhook::query()->where('event', '=', 'posts')->get();
        if($webhooks) {
            foreach($webhooks as $key=>$webhook) {
                try {
                    Log::info('logging webhook');
                    $client->post(
                        $webhook->url, [
                            'body' => $event->post
                        ]
                    );
                } catch (\Exception $e) {
                    LOG::warning('Cant contact', ['data'=>$webhook->url]);
                }
            }
        }
        $post = $event->post;
        LOG::info('sending post data', ['data' => $post->toArray()]);
    }
}
