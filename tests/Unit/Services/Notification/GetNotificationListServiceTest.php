<?php

namespace Tests\Unit\Services\Notification;

use App\Models\Notification;
use App\Services\Interfaces\Notification\GetNotificationListServiceInterface;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class GetNotificationListServiceTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @var GetNotificationListServiceInterface */
    private $getNotificationListService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->getNotificationListService = app(GetNotificationListServiceInterface::class);
    }

    /**
     * @group NotificationService
     */
    public function test_should_get_list(): void
    {
        $notificationCount = 3;

        $generatedNotifications = Notification::factory()->count($notificationCount)->create();
        $generatedNotificationsAsArray = $generatedNotifications->toArray();

        $notifications = $this->getNotificationListService->execute();
        $notificationsAsArray = $notifications->toArray();

        $this->assertCount($notificationCount, $notifications);

        for ($i = 0; $i <= ($notificationCount - 1); $i++) {
            $this->assertEquals($generatedNotificationsAsArray[$i]['recipient_id'], $notificationsAsArray[$i]['recipient_id']);
            $this->assertEquals($generatedNotificationsAsArray[$i]['content'], $notificationsAsArray[$i]['content']);
            $this->assertEquals($generatedNotificationsAsArray[$i]['category'], $notificationsAsArray[$i]['category']);
            $this->assertEquals($generatedNotificationsAsArray[$i]['created_at'], $notificationsAsArray[$i]['created_at']);
            $this->assertEquals($generatedNotificationsAsArray[$i]['updated_at'], $notificationsAsArray[$i]['updated_at']);
        }
    }

    /**
     * @group NotificationService
     */
    public function test_should_get_empty_list_if_table_is_empty(): void
    {
        $notifications = $this->getNotificationListService->execute();
        $this->assertCount(0, $notifications);
    }
}
