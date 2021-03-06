<?php

namespace App\Listeners;

use App\Events\EventEntity;
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
     * @param EventEntity $event
     */
    public function handle(EventEntity $event) : void {
        $this->fireEvent($event);
    }

    /**
     * @param $_event
     */
    protected function fireEvent($_event): void {
        Log::info('----- Start SendEntityEvent / fireEvent -----');
        Log::info('Start sending '.$_event->eventType.' event now');
        $client = new Client();
        //$webhooks = Webhook::query()->whereIn('event', '=', $_event->eventType)->get();
        $webhooks = Webhook::where('event', 'like', '%'.$_event->eventType.'%')->get();
        if($webhooks->count() > 0) {
            foreach($webhooks as $key=>$webhook) {
                Log::info($webhook->url);
                try {
                    Log::info('logging webhook for '.$_event->eventType);
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
            Log::info('No webhooks found for '. $_event->eventType);
        }
        Log::info('----- End SendEntityEvent / fireEvent -----');
    }
}
