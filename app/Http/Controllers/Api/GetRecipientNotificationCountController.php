<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\Notification\GetRecipientNotificationCountServiceInterface;
use App\Traits\Http\HttpResponses;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * @group Notifications
 *
 * Endpoints for managing notifications
 */
class GetRecipientNotificationCountController extends Controller
{
    use HttpResponses;
    
    public function __construct(
        protected GetRecipientNotificationCountServiceInterface $getRecipientNotificationCountService
    ) {}

    /**
     * Count notifications of recipient
     * 
     * This endpoint is used to return a count of notifications related to a specific recipient.
     * 
     */
    public function getCountByRecipient(int $recipientId): JsonResponse
    {
        try {
            $notificationsCount = $this->getRecipientNotificationCountService->execute($recipientId);

            return response()->json([
                'notifications_count' => $notificationsCount
            ]);
        } catch (Throwable $exception) {
            return $this->sendErrorResponse(
                message: 'An error has occurred. Could not get the notifications count by recipient as requested.',
                code: $exception->getCode(),
                data: [
                    'recipient_id' => $recipientId
                ]
            );
        }
    }
}
