<?php


namespace App\Resources;


class WebhookEventOptions
{
    private static $eventOptions = [
        'newFormat',
        'changedFormat',
        'removedFormat',
        'newPost',
        'changedPost',
        'removedPost',
        'newTag',
        'changedTag',
        'removedTag',
        'newTopic',
        'removedTopic',
        'changedTopic'
    ];

    public static function getOptions(): array
    {
        return self::$eventOptions;
    }
}
