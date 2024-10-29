<?php

namespace App\Http\Controllers\Firebase;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Google\Cloud\Firestore\FirestoreClient;

class FirebaseController extends Controller
{
    public function getUsers()
    {
        $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials'));
        $firestore = $factory->createFirestore();
        $database = $firestore->database();

        // Retrieve documents from the 'users' collection
        $documents = $database->collection('users')->documents();

        $users = [];
        foreach ($documents as $document) {
            if ($document->exists()) {
                $users[] = [
                    'id' => $document->id(),
                    'data' => $document->data()
                ];
            }
        }



        // Return the view with the users data
        return view('admin.users.index', compact('users'));
    }



    public function userFriends($user_id)
    {
        // Initialize Firestore
        $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials'));
        $firestore = $factory->createFirestore();
        $database = $firestore->database();

        // Retrieve user data
        $userDoc = $database->collection('users')->document($user_id)->snapshot();

        if (!$userDoc->exists()) {
            return response()->json(['status' => false, 'message' => 'User not found.'], 404);
        }

        $userData = $userDoc->data();

        // Prepare an array to hold friend data
        $friendsDetails = [];

        // Check if the user has friends
        if (!empty($userData['friends'])) {
            foreach ($userData['friends'] as $friendId) {
                // Retrieve friend data
                $friendDoc = $database->collection('users')->document($friendId)->snapshot();

                // dd($friendDoc);

                if ($friendDoc->exists()) {
                    $friendData = $friendDoc->data();
                    $friendsDetails[] = [
                        'friend_id' => $friendData['uid'] ?? null,
                        'displayName' => $friendData['displayName'] ?? null,
                        'email' => $friendData['email'] ?? null,
                        'photoURL' => $friendData['photoURL'] ?? null,
                        'createdAt' => $friendData['createdAt'] ?? null,
                    ];
                }
            }
        }

        return view('admin.users.friends', compact('friendsDetails'));

        // Return the user's friends list with details
        return response()->json([
            'status' => true,
            'friends' => $friendsDetails,
        ], 200);
    }


    public function fetchFriendRequests($user_id)
    {
        // Initialize Firebase Firestore
        $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials'));
        $firestore = $factory->createFirestore();
        $database = $firestore->database();

        // First query where 'senderId' equals the user_id and 'status' is 'pending'
        $friendRequestsSenderRef = $database->collection('friend_requests')
            ->where('senderId', '=', $user_id)
            ->where('status', '=', 'pending');
        $senderDocuments = $friendRequestsSenderRef->documents();

        // Second query where 'receiverId' equals the user_id and 'status' is 'pending'
        $friendRequestsReceiverRef = $database->collection('friend_requests')
            ->where('receiverId', '=', $user_id)
            ->where('status', '=', 'pending');
        $receiverDocuments = $friendRequestsReceiverRef->documents();

        // Merge the results
        $allDocuments = [];
        foreach ($senderDocuments as $document) {
            if ($document->exists()) {
                $userData = $document->data();

                $friendDoc = $database->collection('users')->document($userData['receiverId'])->snapshot();

                // dd($friendDoc);
                if ($friendDoc->exists()) {
                    $friendData = $friendDoc->data();
                    $allDocuments[] = [
                        'friend_id' => $friendData['uid'] ?? null,
                        'displayName' => $friendData['displayName'] ?? null,
                        'email' => $friendData['email'] ?? null,
                        'photoURL' => $friendData['photoURL'] ?? null,
                        'createdAt' => $friendData['createdAt'] ?? null,
                        'type' => 'Sended request'
                    ];
                }
            }
        }

        foreach ($receiverDocuments as $document) {
            if ($document->exists()) {
                // $allDocuments[] = $document->data();

                $userData = $document->data();

                $friendDoc = $database->collection('users')->document($userData['senderId'])->snapshot();

                // dd($friendDoc);
                if ($friendDoc->exists()) {
                    $friendData = $friendDoc->data();
                    $allDocuments[] = [
                        'friend_id' => $friendData['uid'] ?? null,
                        'displayName' => $friendData['displayName'] ?? null,
                        'email' => $friendData['email'] ?? null,
                        'photoURL' => $friendData['photoURL'] ?? null,
                        'createdAt' => $friendData['createdAt'] ?? null,
                        'type' => 'Received request'
                    ];
                }
            }
        }

        // return $allDocuments;
        // Return or process the merged results
        if (empty($allDocuments)) {
            return redirect()->back()->with('error', 'No pending friend requests found');
        }

        return view('admin.users.friendrequests', compact('allDocuments'));

        return response()->json(['status' => true, 'data' => $allDocuments], 200);
    }

    public function deleteUser($user_id)
    {
        // Initialize Firestore
        $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials'));
        $firestore = $factory->createFirestore();
        $database = $firestore->database();

        // Reference the user document
        $userDocRef = $database->collection('users')->document($user_id);

        // Check if the document exists before deleting
        $userDoc = $userDocRef->snapshot();

        if ($userDoc->exists()) {
            // Delete the user document
            $userDocRef->delete();

            return redirect()->back()->with('success', 'User deleted successfully.');
            return response()->json([
                'status' => true,
                'message' => 'User deleted successfully.',
            ], 200);
        } else {

            return redirect()->back()->with('error', 'User not found.');

            return response()->json([
                'status' => false,
                'message' => 'User not found.',
            ], 404);
        }
    }
}
