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

    public function notification_v1(Request $request)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'fcm_token' => 'required|string',
            'body' => 'required|string',
            'title' => 'required|string',
            'type' => 'required|string',  // Custom type of the notification (if needed)
            'sound' => 'required|boolean' // Boolean to indicate if sound should be played
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => false,
                'error' => $validator->errors()
            ], 400);
        }



        // Create Firebase messaging instance
        $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials'));
        $messaging = $factory->createMessaging();

        // Build the notification payload with custom fields
        $notification = Notification::create($request->title, $request->body);

        // Custom data payload
        $dataPayload = [
            'type' => $request->type,
        ];

        // Build the message with notification and custom data
        $message = CloudMessage::withTarget('token', $request->fcm_token)
            ->withNotification($notification)  // Set the notification details
            ->withData($dataPayload);          // Set custom data payload

        // Add sound and icon configuration
        $message = $message->withAndroidConfig(AndroidConfig::fromArray([
            'notification' => [
                'sound' =>   url('public/mixkit-clear-announce-tones-2861.wav'),          // Custom sound URL or 'default' sound for Android
                'icon' => url('public/favicon/favicon-32x32.png'),          // Custom icon URL for Android
            ]
        ]))->withApnsConfig(ApnsConfig::fromArray([
            'payload' => [
                'aps' => [
                    'sound' => url('public/mixkit-clear-announce-tones-2861.wav'),    // Custom sound URL or 'default' sound for iOS
                ]
            ],
            'fcm_options' => [
                'image' => url('public/favicon/favicon-32x32.png'),          // Custom icon for iOS
            ]
        ]));





        // Send the notification
        try {
            $messaging->send($message);
            return response()->json([
                'status' => true,
                'message' => 'Notification sent successfully',
            ], 200);
        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to send notification',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    public function notification_bkp(Request $request)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'fcm_token' => 'required|string',
            'body' => 'required|string',
            'title' => 'required|string',
            'type' => 'required|string',  // Custom type of the notification (if needed)
            'sound' => 'required|boolean' // Boolean to indicate if sound should be played
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => false,
                'error' => $validator->errors()
            ], 400);
        }

        // // Create Firebase messaging instance
        // $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials'));
        // $messaging = $factory->createMessaging();

        // // Determine the sound settings based on the boolean value
        // $sound = $request->sound ? 'default' : null;

        // // Create the message payload
        // $message = CloudMessage::withTarget('token', $request->fcm_token)
        //     ->withNotification([
        //         'title' => $request->title,
        //         'body' => $request->body,
        //         'icon' => url('public/favicon/favicon-32x32.png'), // Adding the notification icon
        //     ])
        //     ->withData([
        //         'type' => $request->type,
        //     ])
        //     ->withAndroidConfig([
        //         'notification' => [
        //             'sound' => $sound,         // Android notification sound
        //             'icon' => url('public/favicon/favicon-32x32.png'),   // Android notification icon
        //         ]
        //     ])
        //     ->withApnsConfig([
        //         'payload' => [
        //             'aps' => [
        //                 'sound' => $sound,     // iOS notification sound
        //                 'mutable-content' => 1 // Enable custom icon handling on iOS (for media notifications)
        //             ]
        //         ],
        //         'fcm_options' => [
        //             'image' => url('public/favicon/favicon-32x32.png'), // Notification image or icon for iOS (for custom media)
        //         ]
        //     ]);






        // Create Firebase messaging instance
        $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials'));
        $messaging = $factory->createMessaging();

        // Build the notification payload (without image support)
        $notification = Notification::create($request->title, $request->body);

        // Custom data payload (include icon URL in data if needed)
        $dataPayload = [
            'type' => $request->type,
            'url' => url('public/mixkit-clear-announce-tones-2861.wav'),  // Custom URL if any
            'icon' => url('public/favicon/favicon-32x32.png'), // You can send the icon URL as part of data
        ];

        // Build the message with custom data
        $message = CloudMessage::withTarget('token', $request->fcm_token)
            ->withNotification($notification)  // Set the notification details
            ->withData($dataPayload);          // Set custom data payload

        // Add sound settings if applicable
        if ($request->sound) {
            $message = $message->withAndroidConfig([
                'notification' => [
                    'sound' => 'default',  // Default sound for Android
                    'icon' => url('public/favicon/favicon-32x32.png') // Set custom icon
                ]
            ])->withApnsConfig([
                'payload' => [
                    'aps' => [
                        'sound' => 'default'  // Default sound for iOS
                    ]
                ]
            ]);
        }



        // Send the notification
        try {
            $messaging->send($message);
            return response()->json([
                'status' => true,
                'message' => 'Notification sent successfully',
            ], 200);
        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to send notification',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function notification_v2(Request $request)
    {
        // Validate the input data
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

        // // Create Firebase messaging instance
        // $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials'));
        // $messaging = $factory->createMessaging();

        // // Create a Firebase notification
        // $notification = FirebaseNotification::create($request->title, $request->body);

        // // Create the CloudMessage with the FCM token and the notification
        // $message = CloudMessage::withTarget('token', $request->fcm_token)
        //     ->withNotification($notification)
        //     ->withData([
        //         'type' => $request->type,  // Add additional data like notification type
        //     ]);


        // Create Firebase messaging instance
        $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials'));
        $messaging = $factory->createMessaging();

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


        // Send the notification
        try {
            $messaging->send($message);


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
                        // 'notification_count' => 42,
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

            $messaging->send($message);


            // $messagings = $factory->createMessaging();
            // $message1 = CloudMessage::withTarget('token', $request->fcm_token)
            // ->withNotification([
            //     'title' => 'Notification title',
            //     'body' => 'Notification body',
            // ])
            // ->withApnsConfig([
            //     'notification' => [
            //         'sound' => 'default',
            //     ],
            //     'payload' => [
            //         'aps' => [
            //             'alert' => [
            //                 'title' => ' up 1.43% on the day',
            //                 'body' => ' gained 11.80 points to close at 835.67, up 1.43% on the day.',
            //             ],
            //             'badge' => 42,
            //         ],
            //     ],
            // ]);

            // $messagings->send($message1);


            // $cloudMessage = CloudMessage::withTarget("topic", 'test')->withNotification([
            //     "title" => $request->title,
            //     "body" => $request->title,
            // ]);

            // $cloudMessage = $cloudMessage->withApnsConfig([
            //     "payload" => [
            //         "aps" => [
            //             "sound" => "default",
            //         ]
            //     ]
            // ]);

            // $cloudMessage = $cloudMessage->withAndroidConfig([
            //     "notification" => [
            //         "default_sound" => true,
            //     ]
            // ]);




            // $data = array();

            // # Shipping Service Creation

            // $messaging = $factory->createMessaging();

            // #Message Assembly for Sending
            // $message = CloudMessage::fromArray([
            //     'token' => $request->fcm_token,
            //     'notification' => [
            //         'title' => $request->title,
            //         'body' => $request->title,
            //     ],
            //     'data' => $data,
            //     'android' => [
            //         'priority' => 'high',
            //         'notification' => [
            //             'default_vibrate_timings' => true,
            //             'default_sound' => true,
            //             'notification_count' => 42,
            //             'notification_priority' => 'PRIORITY_HIGH' // PRIORITY_LOW , PRIORITY_DEFAULT , PRIORITY_HIGH , PRIORITY_MAX
            //         ],
            //     ],
            //     'apns' => [
            //         'headers' => [
            //             'apns-priority' => '10',
            //         ],
            //         'payload' => [
            //             'aps' => [
            //                 'alert' => [
            //                     'title' => $request->title,
            //                     'body' => $request->title,
            //                 ],
            //                 'sound' => 'default',
            //                 'badge' => 42,
            //             ],
            //         ],
            //     ],
            // ]);

            // # Perform message validation
            // $mensagemvalida = true;
            // try {
            //     $messaging->validate($message->withChangedTarget('token', $request->fcm_token));
            // } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            //     $mensagemvalida = false;
            //     return $e->errors();
            // }

            // # If the Message is validated it is sent
            // if ($mensagemvalida) {
            //     try {
            //         $messaging->send($message);
            //     } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            //         return $e->errors();
            //     }
            // }







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

        // Create Firebase messaging instance
        $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials'));
        $messaging = $factory->createMessaging();

        // Determine the sound to use based on the boolean value
        $sound = $request->sound ? 'default' : null; // If true, use 'default', if false, no sound

        // Manually create the payload with sound
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
                'sound' => $sound, // Use sound determined from request input
                'icon' => url('public/favicon/favicon-32x32.png'),
            ]);

        // Send the notification
        try {
            $messaging->send($message);
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
