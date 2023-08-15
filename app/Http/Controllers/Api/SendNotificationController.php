<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Notification\CreateNotificationDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\CreateNotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Services\Interfaces\Notification\SendNotificationServiceInterface;
use App\Traits\Http\HttpResponses;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * @group Notifications
 *
 * Endpoints for managing notifications
 */
class SendNotificationController extends Controller
{
    use HttpResponses;
    
    public function __construct(
        protected SendNotificationServiceInterface $sendNotificationService
    ) {}

    /**
     * Send a notification
     * 
     * This endpoint is used to send a notification to a specific recipient.
     * 
     * @response 200 scenario=success {    
     *   "message": "Notification sent with success.",
     *   "notification": {
     *     "id": 5,
     *     "recipient_id": 111,
     *     "content": "New test notification 98",
     *     "category": "social",
     *     "read_at": null,
     *     "canceled_at": null,
     *     "created_at": "2023-08-15 11:59:26",
     *     "updated_at": "2023-08-15 11:59:26"
     *   }
     * }
     * 
     */
    public function send(CreateNotificationRequest $request): JsonResponse
    {
        try {
            $notification = $this->sendNotificationService->execute(
                CreateNotificationDTO::fromRequest($request)
            );

            return response()->json([
                'message' => 'Notification sent with success.',
                'notification' => new NotificationResource($notification)
            ]);
        } catch (Throwable $exception) {
            return $this->sendErrorResponse(
                message: 'An error has occurred. Could not send the notification.',
                code: $exception->getCode(),
                data: $request->all()
            );
        }
    }
}
