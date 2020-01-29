<?php

namespace App\Listeners;

use App\Events\SavedFormat;


class SendFormatEvent extends SendEntityEvent
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
     * @param SavedFormat $event
     * @return void
     */
    public function handle(SavedFormat $event): void
    {
        $this->fireEvent($event, 'format');
    }
}
