<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FcmService
{
    protected $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
    protected $serverKey;

    public function __construct()
    {
        $this->serverKey = env('FCM_SERVER_KEY');
    }

    public function sendNotifications($deviceToken, $title, $body, $serverKey, $image,$id)
    {

        $data = [
            'id'=> $id,
            'title' => $title,
            'body' => $body,
            'image' => env('APP_URL') . "/storage/" . $image,
        ];
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$serverKey}",
            'Content-Type' => 'application/json',
        ])->withoutVerifying()->post(env('FIREBASE_URL'), [
            "message" => [
                "token" => $deviceToken,
                "notification" => ["title" => $title, "body" => $body],
                "data" => $data,
            ],
        ]);

        return $response->json();
    }
}
