<?php

namespace App\Listeners;


use App\Events\SavedTag;

class SendTagEvent extends SendEntityEvent
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
     * @param SavedTag $event
     * @return void
     */
    public function handle(SavedTag $event): void
    {
        $this->fireEvent($event, 'tag');
    }
}
