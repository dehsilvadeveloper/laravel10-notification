<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotificationNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Services\Interfaces\Notification\GetNotificationServiceInterface;
use App\Traits\Http\HttpResponses;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * @group Notifications
 *
 * Endpoints for managing notifications
 */
class GetNotificationController extends Controller
{
    use HttpResponses;
    
    public function __construct(
        protected GetNotificationServiceInterface $getNotificationService
    ) {}

    /**
     * Get a single notification
     * 
     * This endpoint is used to return a single notification from the database.
     * 
     */
    public function getNotification(int $id): JsonResponse
    {
        try {
            $notification = $this->getNotificationService->execute($id);

            return response()->json([
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
                message: 'An error has occurred. Could not get the notification data as requested.',
                code: $exception->getCode(),
                data: [
                    'id' => $id
                ]
            );
        }
    }
}
