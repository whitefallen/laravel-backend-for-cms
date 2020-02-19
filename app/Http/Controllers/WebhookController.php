<?php

namespace App\Http\Controllers;

use App\Models\Webhook;
use App\Resources\WebhookEventOptions;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class WebhookController extends Controller
{

    public function handle(Request $request) {
        LOG::info('received webhook data');
        $json_data = $request->getContent();
        file_put_contents('webhook_response.json', $json_data);
    }

    /**
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function createWebhook(Request $request) {
        LOG::info('creating webhook');

        $validator = Validator::make($request->all() ,[
            'url' => 'required|string',
        ]);

        if($validator->fails()) {
            return response(array('error' => $validator->messages()));
        }
        $webhook = Webhook::create($request->all());
        LOG::info('created webhook');
        return response(array('info' => 1, 'data' => $webhook));
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

    public function getWebhookOptions() {
        try {
            $eventOptions = WebhookEventOptions::getOptions();
            return response(array('info'=>1,'data' => $eventOptions ));
        }
        catch (Exception $e) {
            return response(array('info'=>0,'message'=>$e));
        }
    }
}
