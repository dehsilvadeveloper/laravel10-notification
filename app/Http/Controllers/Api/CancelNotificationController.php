<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotificationNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Services\Interfaces\Notification\CancelNotificationServiceInterface;
use App\Traits\Http\HttpResponses;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * @group Notifications
 *
 * Endpoints for managing notifications
 */
class CancelNotificationController extends Controller
{
    use HttpResponses;
    
    public function __construct(
        protected CancelNotificationServiceInterface $cancelNotificationService
    ) {}

    /**
     * Cancel a notification
     * 
     * This endpoint is used to cancel a single notification.
     * 
     * @response 200 scenario=success {    
     *   "message": "Notification canceled with success.",
     *   "notification": {
     *     "id": 1,
     *     "content": "New test notification 73",
     *     "category": "professional",
     *     "read_at": null,
     *     "canceled_at": "2023-08-15 11:46:13",
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
    public function cancel(int $id): JsonResponse
    {
        try {
            $notification = $this->cancelNotificationService->execute($id);

            return response()->json([
                'message' => 'Notification canceled with success.',
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
                message: 'An error has occurred. Could not cancel the notification.',
                code: $exception->getCode(),
                data: [
                    'id' => $id
                ]
            );
        }
    }
}
