<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\CreateNotificationRequest;
use App\Services\Interfaces\Notification\SendNotificationServiceInterface;
use App\Traits\Http\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SendNotificationController extends Controller
{
    use HttpResponses;
    
    public function __construct(
        protected SendNotificationServiceInterface $sendNotificationService
    ) {}

    public function send(CreateNotificationRequest $request): void
    {
        //
    }
}
