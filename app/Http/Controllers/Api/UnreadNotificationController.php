<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotificationNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Services\Interfaces\Notification\UnreadNotificationServiceInterface;
use App\Traits\Http\HttpResponses;
use Illuminate\Http\JsonResponse;
use Throwable;

class UnreadNotificationController extends Controller
{
    use HttpResponses;
    
    public function __construct(
        protected UnreadNotificationServiceInterface $unreadNotificationService
    ) {}

    public function unread(int $id): JsonResponse
    {
        try {
            $notification = $this->unreadNotificationService->execute($id);

            return response()->json([
                'message' => 'Notification marked as unread with success.',
                'notification' => new NotificationResource($notification)
            ]);
        } catch (NotificationNotFoundException $exception) {
            return $this->sendErrorResponse(
                message: 'The notification could not be found.',
                code: $exception->getCode(),
                data: [
                    'id' => $id
                ]
            );
        } catch (Throwable $exception) {
            return $this->sendErrorResponse(
                message: 'An error has occurred. Could not mark the notification as unread.',
                code: $exception->getCode(),
                data: [
                    'id' => $id
                ]
            );
        }
    }
}
