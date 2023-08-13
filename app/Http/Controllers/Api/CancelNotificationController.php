<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\Notification\CancelNotificationServiceInterface;
use App\Traits\Http\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CancelNotificationController extends Controller
{
    use HttpResponses;
    
    public function __construct(
        protected CancelNotificationServiceInterface $cancelNotificationService
    ) {}

    public function cancel(int $id): void
    {
        //
    }
}
