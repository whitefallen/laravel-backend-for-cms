<?php

namespace App\Listeners;

use App\Events\SavedPost;
use App\Events\SavedTopic;
use App\Models\Webhook;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendTopicEvent extends SendEntityEvent
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
     * @param SavedTopic $event
     * @return void
     */
    public function handle(SavedTopic $event): void
    {
        $this->fireEvent($event, 'topic');
    }
}
