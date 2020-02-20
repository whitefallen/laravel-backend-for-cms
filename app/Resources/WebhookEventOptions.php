<?php


namespace App\Resources;


class WebhookEventOptions
{
    private static $eventOptions = [
        'newFormat' => 'newFormat',
        'changedFormat' => 'changedFormat',
        'removedFormat' => 'removedFormat',
        'newPost' => 'newPost',
        'changedPost' => 'changedPost',
        'removedPost' => 'removedPost',
        'newTag' => 'newTag',
        'changedTag' => 'changedTag',
        'removedTag' => 'removedTag',
        'newTopic' => 'newTopic',
        'removedTopic' => 'removedTopic',
        'changedTopic' => 'changedTopic'
    ];

    public static function getOptions(): array
    {
        return self::$eventOptions;
    }
}
