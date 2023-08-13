<?php

use App\Http\Controllers\Api\CancelNotificationController;
use App\Http\Controllers\Api\GetNotificationController;
use App\Http\Controllers\Api\GetNotificationListController;
use App\Http\Controllers\Api\GetRecipientNotificationCountController;
use App\Http\Controllers\Api\GetRecipientNotificationListController;
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

    Route::get('/', [GetNotificationListController::class, 'getPaginatedList'])->name('notification::list');

    Route::get(
        '/{id}',
        [GetNotificationController::class, 'getNotification']
    )->where(['id' => '[0-9]+'])->name('notification::get');

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

    Route::prefix('recipient')->group(function () {
        Route::get(
            '/{recipientId}',
            [GetRecipientNotificationListController::class, 'getListByRecipient']
        )->where(['recipientId' => '[0-9]+'])->name('notification::recipient::list-by-recipient');

        Route::get(
            '/{recipientId}/count',
            [GetRecipientNotificationCountController::class, 'getCountByRecipient']
        )->where(['recipientId' => '[0-9]+'])->name('notification::recipient::count-by-recipient');
    });
});
