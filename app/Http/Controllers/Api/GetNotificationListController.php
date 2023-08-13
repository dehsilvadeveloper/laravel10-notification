<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\GetNotificationPaginatedListRequest;
use App\Http\Resources\NotificationCollection;
use App\Http\Resources\NotificationResource;
use App\Services\Interfaces\Notification\GetNotificationPaginatedListServiceInterface;
use App\Traits\Http\HttpResponses;
use Illuminate\Http\JsonResponse;
use Throwable;

class GetNotificationListController extends Controller
{
    use HttpResponses;
    
    public function __construct(
        protected GetNotificationPaginatedListServiceInterface $getNotificationPaginatedListService
    ) {}

    public function getPaginatedList(GetNotificationPaginatedListRequest $request)
    {
        try {
            $page = $request->query('page');
            $pageSize = $request->query('page_size');
            $notifications = $this->getNotificationPaginatedListService->execute($page, $pageSize);

            return new NotificationCollection($notifications);
        } catch (Throwable $exception) {
            dd($exception->getMessage());
            return $this->sendErrorResponse(
                message: 'An error has occurred. Could not get the notifications list as requested.',
                code: $exception->getCode(),
                data: [
                    'page' => $request->query('page'),
                    'page_size' => $request->query('page_size')
                ]
            );
        }
    }
}
