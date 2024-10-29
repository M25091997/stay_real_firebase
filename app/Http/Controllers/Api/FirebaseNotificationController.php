<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\ApnsConfig;

class FirebaseNotificationController extends Controller
{
    protected $messaging;

    public function __construct()
    {
        // Initialize Firebase SDK
        $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials'));
        $this->messaging =  $factory->createMessaging();
    }



    public function notification_v1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fcm_token' => 'required|string', // FCM token for the device/user
            'body' => 'required|string',      // Body of the notification
            'title' => 'required|string',     // Title of the notification
            'type' => 'required|string'       // Type of the notification (for custom handling)
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => false,
                'error' => $validator->errors()
            ], 400);
        }

        // Create a Firebase notification
        $notification = FirebaseNotification::create($request->title, $request->body);

        // Add the 'sound' to the data payload
        $message = CloudMessage::withTarget('token', $request->fcm_token)
            ->withNotification($notification)
            ->withData([
                'type' => $request->type,
                "sound" => "mySound"
                // You can use a custom sound file name here instead of 'default'
            ]);



        try {
            $this->messaging->send($message);

            $message = CloudMessage::fromArray([
                'token' => $request->fcm_token,
                'notification' => ['title' => 'test', 'body' => 'demo body'],
                'data' => ['hi' => 'hi'], // optional
                'android' => [
                    'priority' => 'high',
                    'notification' => [
                        "sound" => "default",
                        'default_vibrate_timings' => true,
                        'default_sound' => true,
                        'notification_count' => 42,
                        'color' => '#1a73e8',
                        'icon' => url('public/favicon/favicon-32x32.png'),
                        'notification_priority' => 'PRIORITY_MAX' // PRIORITY_LOW , PRIORITY_DEFAULT , PRIORITY_HIGH , PRIORITY_MAX
                    ],
                ],
                'apns' => [
                    'headers' => [
                        'apns-priority' => '10',
                    ],
                    'payload' => [
                        'aps' => [
                            'alert' => [
                                'title' => '$GOOG up 1.43% on the day',
                                'body' => '$GOOG gained 11.80 points to close at 835.67, up 1.43% on the day.',
                            ],
                            "sound" => "default",
                            'badge' => 42,
                        ],
                    ],
                ],

            ]);

            $this->messaging->send($message);

            return response()->json([
                'status' => true,
                'message' => 'Notification sent successfully!',
            ], 200);
        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            // Handle messaging exception
            return response()->json([
                'status' => false,
                'message' => 'Failed to send notification.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function notification_v2(Request $request)
    {
        try {

            $message = CloudMessage::withTarget('token', $request->fcm_token)
                ->withNotification(Notification::create($request->title, $request->body))

                // iOS configuration (ApnsConfig) with sound and badge
                ->withApnsConfig(ApnsConfig::new()->withDefaultSound()->withBadge(1))

                // Android configuration (AndroidConfig) with sound
                ->withAndroidConfig(AndroidConfig::new()->withSound('default')->withPriority('high'));

            // Send the message
            $this->messaging->send($message);


            return [
                'success' => true,
                'message' => 'Notification sent successfully',
            ];
        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            return [
                'success' => false,
                'message' => 'Error sending notification: ' . $e->getMessage(),
            ];
        }
    }


    public function notification(Request $request)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'fcm_token' => 'required|string', // FCM token for the device/user
            'body' => 'required|string',      // Body of the notification
            'title' => 'required|string',     // Title of the notification
            'type' => 'required|string',      // Type of the notification (for custom handling)
            'sound' => 'required|boolean'     // Sound should be a boolean
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => false,
                'error' => $validator->errors()
            ], 400);
        }


        $sound = $request->sound ? 'default' : null;


        $message = CloudMessage::withTarget('token', $request->fcm_token)
            ->withData([
                'title' => $request->title,
                'body' => $request->body,
                'type' => $request->type,
                'sound' => $sound,
                'icon' => url('public/favicon/favicon-32x32.png'),
            ])
            ->withNotification([
                'title' => $request->title,
                'body' => $request->body,
                'sound' => $sound,
                'icon' => url('public/favicon/favicon-32x32.png'),
            ]);



        // Send the notification
        try {
            $this->messaging->send($message);

            return response()->json([
                'status' => true,
                'message' => $message,
            ], 200);
        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            // Handle messaging exception
            return response()->json([
                'status' => false,
                'message' => 'Failed to send notification.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
