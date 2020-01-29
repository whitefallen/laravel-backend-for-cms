<?php

namespace App\Listeners;

use App\Events\SavedFormat;
use App\Events\SavedPost;
use App\Models\Webhook;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendEntityEvent
{
    /**
     * @param $_event
     * @param string $_eventType
     */
    protected function fireEvent($_event, string $_eventType): void {
        Log::info('----- Start SendEntityEvent / fireEvent -----');
        Log::info('Start sending '.$_eventType.' event now');
        $client = new Client();
        $webhooks = Webhook::query()->where('event', '=', $_eventType)->get();
        if($webhooks->count() > 0) {
            foreach($webhooks as $key=>$webhook) {
                Log::info($webhook->url);
                try {
                    Log::info('logging webhook for '.$_eventType);
                    $client->post(
                        $webhook->url, [
                            'body' => $_event->data
                        ]
                    );
                    $data = $_event->data;
                    LOG::info('End sending data to '.$webhook->url, ['data' => $data]);
                } catch (\Exception $e) {
                    LOG::warning('Cant contact', ['data'=>$webhook->url]);
                }
            }
        } else {
            Log::info('No webhooks found for '. $_eventType);
        }
        Log::info('----- End SendEntityEvent / fireEvent -----');
    }
}
