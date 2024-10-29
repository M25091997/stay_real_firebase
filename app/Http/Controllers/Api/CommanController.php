<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommanController extends Controller
{
    public function getAlluser()
    {
        $users = User::where('is_active', 1)->get();

        return response()->json([
            'status' =>  true,
            'data' => $users,
        ], 200);
    }


    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'query' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status' => false, 'error' => $validator->errors()], 400);
        }

        $query = $request->input('query');

        // Search users by name or email
        $users = User::where('name', 'like', '%' . $query . '%')
            ->orWhere('email', 'like', '%' . $query . '%')
            ->get();

        // Return the results as JSON
        return response()->json([
            'status' => 'success',
            'data' => $users,
        ]);
    }

    // Add a friend
    public function addFriend(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'friend_id' => 'required|integer|exists:users,id', // Corrected 'exits' to 'exists'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => false,
                'error' => $validator->errors()
            ], 400);
        }


        $friend = User::find($request->friend_id);

        $user = $request->user();

        if ($friend) {
            $user->friends()->attach($friend->id);
            return response()->json(['status' => 'success', 'message' => 'Friend added successfully.']);
        }

        return response()->json(['status' => 'error', 'message' => 'Friend not found.']);
    }


    // Remove a friend
    public function removeFriend(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'friend_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status' => false, 'error' => $validator->errors()], 400);
        }

        $friend = User::find($request->friend_id);

        $user = $request->user();

        if ($friend) {
            $user->friends()->detach($friend->id);
            return response()->json(['status' => 'success', 'message' => 'Friend removed successfully.']);
        }

        return response()->json(['status' => 'error', 'message' => 'Friend not found.']);
    }


    public function getFriendsList(Request $request)
    {
        $user = auth()->user(); // Assuming you're using Passport or Sanctum for authentication

        $friends = $user->friends()->get(); // Fetch the friends list

        return response()->json([
            'status' => true,
            'friends' => $friends,
        ], 200);
    }
}
