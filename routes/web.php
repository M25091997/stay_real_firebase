<?php

use App\Http\Controllers\AmenityController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\FoodCategoryController;
use App\Http\Controllers\FoodItemController;
use App\Http\Controllers\FoodOrderController;
use App\Http\Controllers\FoodSubCategoryController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\HotelRoomController;
use App\Http\Controllers\RoomCategoryController;
use App\Http\Controllers\RoomSubCategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommanController;
use App\Http\Controllers\Firebase\LocationController;
use App\Http\Controllers\Firebase\FirebaseController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/monitor-locations', [LocationController::class, 'monitorUserLocations']);


Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/users', [FirebaseController::class, 'getUsers']);
    Route::get('/admin/{user_id}/friends', [FirebaseController::class, 'userFriends'])->name('user.friends');
    Route::get('/admin/{user_id}/requestFriends', [FirebaseController::class, 'fetchFriendRequests'])->name('user.requestFriends');
    Route::delete('/admin/{user_id}/delete', [FirebaseController::class, 'deleteUser'])->name('delete.user');
});

require __DIR__ . '/auth.php';
