<?php

namespace App\Http\Controllers;

use App\Models\Webhook;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class WebhookController extends Controller
{
    /**
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function handle(Request $request) {
        LOG::critical('made it here');
        return response(array('data'=>'responed'));
    }

    /**
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function webhookAction(Request $request) {
        LOG::critical('starting to hit webhook');
        $client = new Client();
        $res = $client->get('http://localhost:8001/api/webhook');
        LOG::critical('ending to hit webhook');
        return response(array('data'=>'responed'));
    }

    /**
     * @param Request $request
     * @return ResponseFactory|Response
     */
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

    /**
     * @return ResponseFactory|Response
     */
    public function getAllWebhook() {
        return response(array('info' => 1, 'data' => Webhook::all()));
    }

    /**
     * @param int $id
     * @return ResponseFactory|Response
     */
    public function getWebhookById(int $id) {
        try{
            $webhook = Webhook::findOrFail($id);
            return response(array('info'=>1,'data' => $webhook ));
        }catch(ModelNotFoundException $e){
            return response(array('info'=>0,'message'=>'No Webhook found with provided ID'));
        }catch(Exception $e){
            return response(array('info'=>0,'message'=>$e));
        }
    }

    /**
     * @param string $event
     * @return ResponseFactory|Response
     */
    public function getWebhookByEvent(string $event) {
        try{
            $webhook = Webhook::findOrFail($event);
            return response(array('info'=>1,'data' => $webhook ));
        }catch(ModelNotFoundException $e){
            return response(array('info'=>0,'message'=>'No Webhook found with provided Event'));
        }catch(Exception $e){
            return response(array('info'=>0,'message'=>$e));
        }
    }
}
