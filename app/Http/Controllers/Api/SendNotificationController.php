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

class SendNotificationController extends Controller
{
    use HttpResponses;
    
    public function __construct(
        protected SendNotificationServiceInterface $sendNotificationService
    ) {}

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
