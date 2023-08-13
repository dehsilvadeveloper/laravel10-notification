<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\Notification\GetRecipientNotificationListServiceInterface;
use App\Traits\Http\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetRecipientNotificationListController extends Controller
{
    use HttpResponses;
    
    public function __construct(
        protected GetRecipientNotificationListServiceInterface $getRecipientNotificationListService
    ) {}

    public function getListByRecipient(int $recipientId): void
    {
        //
    }
}
