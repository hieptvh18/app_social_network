<?php

namespace Modules\Core\Services;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;


class NotificationService
{
    public function updateDeviceToken(Request $request)
    {
        try {
            auth()->user()->device_token = $request->token;
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function sendNotification(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $FcmToken = User::whereNotNull('device_key')->pluck('device_key')->all();

        $serverKey = 'AAAADSuZRdE:APA91bEg-6e-r8Ypyqm7I8EuIOt4CvD94k94gWrTMKFb8KBfvxtj0HMzwBhA2N9JI7xojYuvQvQ6O73slFDwTchvGtPSwCTd_8LVx2t0nCw4hGPQeIzP8k8sy3MD3yUEnlO8L8IqHarw';

        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
            ]
        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        curl_close($ch);

        dd($result);
    }
}
