<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GoogleController extends Controller
{
    public function handleGoogleCallback(Request $request)
    {
        try {
            // $googleUser = Socialite::driver('google')->stateless()->user();

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required',
                'google_id' => 'required',
                'uid' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first(), 'status' => false, 'error' => $validator->errors()], 400);
            }

            // Check if the user already exists
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                // Create a new user if doesn't exist
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'google_id' => $request->google_id,
                    'uid' => $request->uid,
                    'password' => bcrypt(uniqid()), // Random password as it's not used for Google login
                ]);
            }

            // Log in the user
            Auth::login($user);

            $token = $user->createToken('Personal Access Token')->accessToken;

            // Return user data or token as API response
            return response()->json([
                'status' => true,
                'message' => 'User login successfully.',
                'data' => $user,
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
