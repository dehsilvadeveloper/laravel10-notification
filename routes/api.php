<?php

use App\Http\Controllers\Api\CancelNotificationController;
use App\Http\Controllers\Api\ReadNotificationController;
use App\Http\Controllers\Api\SendNotificationController;
use App\Http\Controllers\Api\UnreadNotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return response()->json([
        'success' => true
    ]);
});

Route::prefix('notification')->group(function () {
    Route::post('/', [SendNotificationController::class, 'send'])->name('notification::send');
    Route::patch(
        '/{id}/cancel',
        [CancelNotificationController::class, 'cancel']
    )->where(['id' => '[0-9]+'])->name('notification::cancel');
    Route::patch(
        '/{id}/read',
        [ReadNotificationController::class, 'read']
    )->where(['id' => '[0-9]+'])->name('notification::read');
    Route::patch(
        '/{id}/unread',
        [UnreadNotificationController::class, 'unread']
    )->where(['id' => '[0-9]+'])->name('notification::unread');
});
