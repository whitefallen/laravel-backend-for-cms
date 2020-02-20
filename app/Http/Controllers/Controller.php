<?php

namespace App\Http\Controllers;

use App\Events\EventEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param string $_event
     * @param Model $_dataObject
     */
    protected function fireEvent(string $_event, Model $_dataObject) : void {
        Log::info('----- Start Controller / fireEvent -----');
        LOG::info('trying to send event');
        // Fire event to trigger webhooks
        $event = null;
        try {
            event(new EventEntity($_dataObject, $_event));
        } catch (\Exception $e) {
            LOG::Warning('No API Server online');
            LOG::critical('Error', ['message' => $e->getMessage()]);
        }
        Log::info('----- End Controller / fireEvent -----');
    }

    protected function getImageExtensionFromBase64(string $imageString) : string {
        $extension = '';
        $substring_start = strpos($imageString, 'data:image/');
        $substring_start += strlen('data:image/');
        $size = strpos($imageString, ';base64', $substring_start) - $substring_start;
        $extension = substr($imageString, $substring_start, $size);
        Log::info('Image extension is', ['extension' => $extension]);
        return $extension;
    }

    protected function getImageDataStringFromBase64(string $imageString): string {
        $substring_start = strpos($imageString, ';base64');
        $substring_start += strlen(';base64');
        $data = substr($imageString, $substring_start);
        Log::info('Image data is', ['extension' => $data]);
        return $data;
    }

    protected function processBase64String($image): string
    {
        $imagePath = '';
        if (preg_match('/^data:image\/(\w+);base64,/', $image)) {
            $extension = $this->getImageExtensionFromBase64($image);
            $imgData = $this->getImageDataStringFromBase64($image);
            $img = base64_decode($imgData);
            $imguid = uniqid('img_', true);
            $imgName = $imguid .'.'.$extension;
            Storage::disk('public')->put('/topicImages/'.$imgName, $img);
            $imagePath = 'storage/topicImages/'.$imgName;

        }
        return $imagePath;
    }

}
