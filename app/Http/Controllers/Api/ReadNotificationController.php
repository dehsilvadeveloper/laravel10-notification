<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotificationNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Services\Interfaces\Notification\ReadNotificationServiceInterface;
use App\Traits\Http\HttpResponses;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * @group Notifications
 *
 * Endpoints for managing notifications
 */
class ReadNotificationController extends Controller
{
    use HttpResponses;
    
    public function __construct(
        protected ReadNotificationServiceInterface $readNotificationService
    ) {}

    /**
     * Read a notification
     * 
     * This endpoint is used to mark a single notification as READ.
     * 
     * @response 200 scenario=success {    
     *   "message": "Notification marked as read with success.",
     *   "notification": {
     *     "id": 1,
     *     "recipient_id": 257,
     *     "content": "New test notification 12",
     *     "category": "professional",
     *     "read_at": "2023-08-15 11:46:13",
     *     "canceled_at": null,
     *     "created_at": "2023-08-13 17:09:53",
     *     "updated_at": "2023-08-15 11:46:13"
     *   }
     * }
     * @response status=404 scenario="notification not found" {
     *   "message": "The notification could not be found.",
     *   "data": {
     *       "id": 99999
     *   }
     * }
     * 
     */
    public function read(int $id): JsonResponse
    {
        try {
            $notification = $this->readNotificationService->execute($id);

            return response()->json([
                'message' => 'Notification marked as read with success.',
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
                message: 'An error has occurred. Could not mark the notification as read.',
                code: $exception->getCode(),
                data: [
                    'id' => $id
                ]
            );
        }
    }
}
