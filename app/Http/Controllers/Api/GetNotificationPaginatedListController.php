<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\Notification\GetNotificationPaginatedListServiceInterface;
use App\Traits\Http\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetNotificationPaginatedListController extends Controller
{
    use HttpResponses;
    
    public function __construct(
        protected GetNotificationPaginatedListServiceInterface $getNotificationPaginatedListService
    ) {}

    public function getPaginatedList(int $page, int $pageSize): void
    {
        //
    }
}
