<?php

use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\CommanController;
use App\Http\Controllers\Api\FirebaseNotificationController;
use App\Http\Controllers\Api\GoogleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('google/callback', [GoogleController::class, 'handleGoogleCallback']);




Route::post('notification_v1', [FirebaseNotificationController::class, 'notification_v1']);
Route::post('notification_v2', [FirebaseNotificationController::class, 'notification_v2']);
Route::post('notification', [FirebaseNotificationController::class, 'notification']);

Route::middleware('auth:api')->group(function () {

    Route::get('get-users', [CommanController::class, 'getAlluser']);
    Route::post('users/search', [CommanController::class, 'search']);


    // Friend routes
    Route::post('friends-add', [CommanController::class, 'addFriend']);
    Route::delete('friends-remove', [CommanController::class, 'removeFriend']);
    Route::get('friends', [CommanController::class, 'getFriendsList']);


    // Chat routes
    Route::post('chats-send', [ChatController::class, 'sendMessage']);
    Route::post('chats-messages', [ChatController::class, 'getMessages']);
});

Route::middleware('auth:passport')->get('/user', function (Request $request) {
    return $request->user();
});
