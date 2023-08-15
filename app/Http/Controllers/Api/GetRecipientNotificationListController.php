<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Services\Interfaces\Notification\GetRecipientNotificationListServiceInterface;
use App\Traits\Http\HttpResponses;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * @group Notifications
 *
 * Endpoints for managing notifications
 */
class GetRecipientNotificationListController extends Controller
{
    use HttpResponses;
    
    public function __construct(
        protected GetRecipientNotificationListServiceInterface $getRecipientNotificationListService
    ) {}

    /**
     * Get notifications of recipient
     * 
     * This endpoint is used to return a list of notifications related to a specific recipient.
     * 
     * @response 200 scenario=success {    
    *    "notifications": [
    *        {
    *            "id": 1,
    *            "recipient_id": 637,
    *            "content": "New test notification 73",
    *            "category": "social",
    *            "read_at": null,
    *            "canceled_at": null,
    *            "created_at": "2023-08-13 17:09:53",
    *            "updated_at": "2023-08-15 11:46:13"
    *        },
    *        {
    *            "id": 2,
    *            "recipient_id": 637,
    *            "content": "New test notification 55",
    *            "category": "professional",
    *            "read_at": null,
    *            "canceled_at": null,
    *            "created_at": "2023-08-13 17:09:53",
    *            "updated_at": "2023-08-15 11:46:13"
    *        }
    *    ]
     * }
     * 
     */
    public function getListByRecipient(int $recipientId): JsonResponse
    {
        try {
            $notifications = $this->getRecipientNotificationListService->execute($recipientId);

            return response()->json([
                'notifications' => NotificationResource::collection($notifications)
            ]);
        } catch (Throwable $exception) {
            return $this->sendErrorResponse(
                message: 'An error has occurred. Could not get the notifications list by recipient as requested.',
                code: $exception->getCode(),
                data: [
                    'recipient_id' => $recipientId
                ]
            );
        }
    }
}
