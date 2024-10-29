<?php

namespace App\Http\Controllers\Firebase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;
use App\Models\Notification; // Laravel Notification model
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    protected $database;
    protected $messaging;

    public function __construct()
    {
        // Initialize Firebase Database and Messaging
        // $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials'));
        $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials'));
        $this->database = $factory->createDatabase();
        $this->messaging = $factory->createMessaging();
    }


    // // Function to monitor and listen to user locations
    // public function monitorUserLocations()
    // {
    //     // Listen for all users' location updates
    //     $usersRef = $this->database->getReference('users');

    //     // Get all users' data (locations)
    //     $users = $usersRef->getValue();

    //     foreach ($users as $userId => $userData) {
    //         if (isset($userData['location'])) {
    //             $latitude = $userData['location']['latitude'];
    //             $longitude = $userData['location']['longitude'];

    //             // Calculate distance for this user with others
    //             $this->calculateDistancesForUser($userId, $latitude, $longitude, $users);
    //         }
    //     }
    // }

    // // Calculate the distance between a user and all other users
    // private function calculateDistancesForUser($userId, $userLat, $userLon, $allUsers)
    // {
    //     foreach ($allUsers as $otherUserId => $otherUserData) {
    //         if ($userId !== $otherUserId && isset($otherUserData['location'])) {
    //             $otherLat = $otherUserData['location']['latitude'];
    //             $otherLon = $otherUserData['location']['longitude'];

    //             // Calculate distance between user and the other user
    //             $distance = $this->calculateDistance($userLat, $userLon, $otherLat, $otherLon);

    //             // Check if the distance is within 100 meters
    //             if ($distance <= 100) {
    //                 // Trigger an action, e.g., send push notification
    //                 $this->sendProximityNotification($userId, $otherUserId, $distance);
    //             }
    //         }
    //     }
    // }

    // // Helper function to calculate the distance using the Haversine formula
    // public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    // {
    //     $earthRadius = 6371000; // Earth's radius in meters

    //     $latFrom = deg2rad($lat1);
    //     $lonFrom = deg2rad($lon1);
    //     $latTo = deg2rad($lat2);
    //     $lonTo = deg2rad($lon2);

    //     $latDelta = $latTo - $latFrom;
    //     $lonDelta = $lonTo - $lonFrom;

    //     $a = sin($latDelta / 2) * sin($latDelta / 2) +
    //         cos($latFrom) * cos($latTo) *
    //         sin($lonDelta / 2) * sin($lonDelta / 2);

    //     $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    //     $distance = $earthRadius * $c;

    //     return $distance; // Distance in meters
    // }

    // // Function to send push notification (example placeholder)
    // public function sendProximityNotification($userId, $otherUserId, $distance)
    // {
    //     // Code to send notification to the user
    //     // This can be integrated with Firebase Cloud Messaging (FCM) or any other push notification service
    // }




    // Function to monitor user locations and calculate distances
    public function monitorUserLocations()
    {
        // $usersRef = $this->database->getReference('users'); // Assuming 'users' node in Firebase
        // $users = $usersRef->getValue();

        $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials'));
        $firestore = $factory->createFirestore();
        $database = $firestore->database();

        // Retrieve documents from the 'users' collection
        $users = $database->collection('users')->documents();

        // dd($users);

        if ($users) {
            foreach ($users as $userId => $userDoc) {

                $userData = $userDoc->data();

                // dd( $userData);

                if (isset($userData)) {
                    $latitude = $userData['latitude'];
                    $longitude = $userData['longitude'];
                    $userId = $userData['uid'];

                    // dd($longitude);

                    $this->calculateDistancesForUser($userId, $latitude, $longitude, $users);
                }
            }
        }
    }

    // Function to calculate the distance between users and send notifications
    private function calculateDistancesForUser($userId, $userLat, $userLon, $allUsers)
    {
        // dd($allUsers);
        foreach ($allUsers as $otherUserData) {

            $otherUserData = $otherUserData->data();

            // dd($otherUserData);


            if (isset($otherUserData) && $userId !== $otherUserData['uid']) {
                $otherLat = $otherUserData['latitude'];
                $otherLon = $otherUserData['longitude'];



                $distance = $this->calculateDistance($userLat, $userLon, $otherLat, $otherLon);

                if ($distance <= 100) {  // If within 100 meters
                    $this->sendProximityNotification($userId, $otherUserData['uid'], $distance);
                }
            }
        }
    }

    // Send FCM notification and save notification in database
    public function sendProximityNotification($userId, $otherUserId, $distance)
    {
        // Get FCM token for both users (retrieve from Firebase or your DB)
        $userData = $this->getUserData($userId); // Replace with actual token retrieval logic
        $otherUserData = $this->getUserData($otherUserId); // Replace with actual token retrieval logic

        $userToken = $userData['fcmToken'];
        $otherUserToken =  $otherUserData['fcmToken'];

        return;



        $userMessage = "User {$otherUserData['displayName']} is within {$distance} meters";
        $message = "User {$otherUserData['displayName']} is within {$distance} meters";

        // Create FCM Notification
        $notification = FirebaseNotification::create('Stay Real Alert', $message);

        // Send notification to both users
        $userMessage = CloudMessage::withTarget('token',  $otherUserToken)
            ->withNotification($notification);

        $otherUserMessage = CloudMessage::withTarget('token', $userToken)
            ->withNotification($notification);

        $this->messaging->send($userMessage);
        $this->messaging->send($otherUserMessage);

        // Save notification to the database
        // Notification::create([
        //     'user_id' => $userId,
        //     'other_user_id' => $otherUserId,
        //     'message' => $message,
        //     'distance' => $distance,
        // ]);

        $this->saveProximityNotification($userId, $otherUserId, $distance);
    }

    // Haversine formula to calculate distance between two points (in meters)
    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // in meters

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // dd($earthRadius * $c);

        return round($earthRadius * $c, 2); // return distance in meters
    }

    // Placeholder function to get FCM user token (implement your logic)
    public function getUserData($userId)
    {
        $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials'));
        $firestore = $factory->createFirestore();
        $database = $firestore->database();

        // Reference the user document
        $userDocRef = $database->collection('users')->document($userId);

        // Check if the document exists before deleting
        $userDoc = $userDocRef->snapshot();

        return $userDoc;
    }


    public function saveProximityNotification($userId, $otherUserId, $distance)
    {
        // Existing code for FCM and database notification

        // Save notification in Firebase Realtime Database
        // $notificationRef = $this->database->getReference('notifications')->push([
        //     'user_id' => $userId,
        //     'other_user_id' => $otherUserId,
        //     'message' => "User {$otherUserId} is within {$distance} meters",
        //     'distance' => $distance,
        //     'timestamp' => now()->toDateTimeString(),
        // ]);

        return 200;
    }



    public function listenForLocationUpdates()
    {
        $usersRef = $this->database->getReference('users');

        $usersRef->getSnapshot()->getValue()->listen(function ($snapshot) {
            $users = $snapshot->getValue();

            foreach ($users as $userId => $userData) {
                if (isset($userData['location'])) {
                    // Handle user location data and calculate distances
                    $latitude = $userData['location']['latitude'];
                    $longitude = $userData['location']['longitude'];
                    $this->calculateDistancesForUser($userId, $latitude, $longitude, $users);
                }
            }
        });
    }
}
