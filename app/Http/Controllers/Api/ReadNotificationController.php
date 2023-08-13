<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\Notification\ReadNotificationServiceInterface;
use App\Traits\Http\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReadNotificationController extends Controller
{
    use HttpResponses;
    
    public function __construct(
        protected ReadNotificationServiceInterface $readNotificationService
    ) {}

    public function read(int $id): void
    {
        //
    }
}
