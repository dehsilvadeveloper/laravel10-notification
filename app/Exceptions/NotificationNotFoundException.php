<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class NotificationNotFoundException extends Exception
{
    protected $message = 'Notification not found';
    protected $code = Response::HTTP_NOT_FOUND;

    public function __construct(
        protected string $caller,
        protected int $notificationId
    ) {}

    public function context(): array
    {
        return [
            'caller' => $this->caller,
            'notification_id' => $this->notificationId
        ];
    }

    public function report()
    {
        Log::warning($this->message, $this->context());
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json(
            [
                'error' => $this->message
            ],
            $this->code
        );
    }
}
