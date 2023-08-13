<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\Notification\GetRecipientNotificationCountServiceInterface;
use App\Traits\Http\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetRecipientNotificationCountSController extends Controller
{
    use HttpResponses;
    
    public function __construct(
        protected GetRecipientNotificationCountServiceInterface $getRecipientNotificationCountService
    ) {}

    public function getCount(int $recipientId): void
    {
        //
    }
}
