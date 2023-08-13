<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Services\Interfaces\Notification\GetRecipientNotificationListServiceInterface;
use App\Traits\Http\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class GetRecipientNotificationListController extends Controller
{
    use HttpResponses;
    
    public function __construct(
        protected GetRecipientNotificationListServiceInterface $getRecipientNotificationListService
    ) {}

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
