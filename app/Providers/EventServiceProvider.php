<?php

namespace App\Providers;

use App\Events\SavedFormat;
use App\Events\SavedPost;
use App\Events\SavedTag;
use App\Events\SavedTopic;
use App\Listeners\SendFormatEvent;
use App\Listeners\SendPostEvent;
use App\Listeners\SendTagEvent;
use App\Listeners\SendTopicEvent;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SavedPost::class => [
            SendPostEvent::class
        ],
        SavedTopic::class => [
            SendTopicEvent::class
        ],
        SavedFormat::class => [
            SendFormatEvent::class
        ],
        SavedTag::class => [
            SendTagEvent::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
