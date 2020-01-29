<?php

namespace App\Listeners;

use App\Events\SavedPost;

class SendPostEvent extends SendEntityEvent
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
        $this->fireEvent($event, 'post');
    }
}
