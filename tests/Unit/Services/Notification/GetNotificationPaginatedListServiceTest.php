<?php

namespace Tests\Unit\Services\Notification;

use App\Models\Notification;
use App\Services\Interfaces\Notification\GetNotificationPaginatedListServiceInterface;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class GetNotificationPaginatedListServiceTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @var GetNotificationPaginatedListServiceInterface */
    private $getNotificationPaginatedListService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->getNotificationPaginatedListService = app(GetNotificationPaginatedListServiceInterface::class);
    }

    /**
     * @group NotificationService
     */
    public function test_should_get_paginated_list(): void
    {
        $notificationCount = 20;
        $pageSize = 10;
        $page = 2;

        $generatedNotifications = Notification::factory()->count($notificationCount)->create();
        $generatedNotificationsAsArray = $generatedNotifications->toArray();

        $notifications = $this->getNotificationPaginatedListService->execute($page, $pageSize);
        $notificationsAsArray = $notifications->toArray();

        $this->assertInstanceOf(LengthAwarePaginator::class, $notifications);
        $this->assertEquals($notificationCount, $notificationsAsArray['total']);
        $this->assertEquals($pageSize, $notificationsAsArray['per_page']);
        $this->assertEquals($page, $notificationsAsArray['current_page']);
        $this->assertEquals($generatedNotificationsAsArray[10]['recipient_id'], $notificationsAsArray['data'][0]['recipient_id']);
        $this->assertEquals($generatedNotificationsAsArray[10]['content'], $notificationsAsArray['data'][0]['content']);
        $this->assertEquals($generatedNotificationsAsArray[10]['category'], $notificationsAsArray['data'][0]['category']);
        $this->assertEquals($generatedNotificationsAsArray[10]['created_at'], $notificationsAsArray['data'][0]['created_at']);
        $this->assertEquals($generatedNotificationsAsArray[10]['updated_at'], $notificationsAsArray['data'][0]['updated_at']);
    }

    /**
     * @group NotificationService
     */
    public function test_should_get_empty_paginated_list_if_table_is_empty(): void
    {
        $pageSize = 10;
        $page = 1;

        $notifications = $this->getNotificationPaginatedListService->execute($page, $pageSize);
        $notificationsAsArray = $notifications->toArray();

        $this->assertEquals(0, $notificationsAsArray['total']);
        $this->assertEquals($pageSize, $notificationsAsArray['per_page']);
        $this->assertEquals($page, $notificationsAsArray['current_page']);
        $this->assertEmpty($notificationsAsArray['data']);
    }
}
