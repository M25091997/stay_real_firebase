<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Message;
use App\Models\User;

class ChatController extends Controller
{
    // Send a message
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
            'friend_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status' => false, 'error' => $validator->errors()], 400);
        }

        $user = $request->user();


        $message = Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $request->friend_id,
            'message' => $request->message,
        ]);

        return response()->json(['status' => true, 'data' => $message]);
    }

    // Get chat messages between user and friend
    public function getMessages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'friend_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status' => false, 'error' => $validator->errors()], 400);
        }

        $userId = $request->user()->id;
        $friend_id = $request->friend_id;


        $messages = Message::where(function ($query) use ($userId, $friend_id) {
            $query->where('sender_id', $userId)->where('receiver_id', $friend_id);
        })->orWhere(function ($query) use ($userId, $friend_id) {
            $query->where('sender_id', $friend_id)->where('receiver_id', $userId);
        })->latest()->get();

        return response()->json(['status' => true, 'data' => $messages]);
    }
}
