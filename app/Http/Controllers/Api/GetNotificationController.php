<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\Notification\GetNotificationServiceInterface;
use App\Traits\Http\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetNotificationController extends Controller
{
    use HttpResponses;
    
    public function __construct(
        protected GetNotificationServiceInterface $getNotificationService
    ) {}

    public function getNotification(int $id): void
    {
        //
    }
}
