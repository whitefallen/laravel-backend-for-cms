<?php

namespace App\Http\Controllers;

use App\Models\Webhook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;

class WebhookController extends Controller
{
    public function handle(Request $request) {
        LOG::critical('made it here');
        return response(array('data'=>'responed'));
    }

    public function webhookAction(Request $request) {
        LOG::critical('starting to hit webhook');
        $client = new Client();
        $res = $client->get('http://localhost:8001/api/webhook');
        LOG::critical('ending to hit webhook');
        return response(array('data'=>'responed'));
    }

    public function createWebhook(Request $request) {
        LOG::info('creating webhook');

        $validator = Validator::make($request->all() ,[
            'url' => 'required|string',
            'event' => 'required|string'
        ]);

        if($validator->fails()) {
            return response(array('error' => $validator->messages()));
        }
        Webhook::create($request->all());
        return response(array('info' => '1'));
    }
}
