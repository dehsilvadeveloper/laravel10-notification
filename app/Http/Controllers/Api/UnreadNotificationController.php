<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\Notification\UnreadNotificationServiceInterface;
use App\Traits\Http\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CancelNotificationController extends Controller
{
    use HttpResponses;
    
    public function __construct(
        protected UnreadNotificationServiceInterface $unreadNotificationService
    ) {}

    public function unread(int $id): void
    {
        //
    }
}
