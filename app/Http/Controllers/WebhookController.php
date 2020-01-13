<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

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
}
