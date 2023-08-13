<?php

namespace Tests\Unit\Services\Notification;

use App\Models\Notification;
use App\Services\Interfaces\Notification\GetRecipientNotificationListServiceInterface;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class GetRecipientNotificationListServiceTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @var GetRecipientNotificationListServiceInterface */
    private $getRecipientNotificationListService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->getRecipientNotificationListService = app(GetRecipientNotificationListServiceInterface::class);
    }

    /**
     * @group NotificationService
     */
    public function test_should_get_list(): void
    {
        $notificationCount = 3;
        $recipientId = 7;

        $generatedNotifications = Notification::factory()
            ->count($notificationCount)
            ->create([
                'recipient_id' => $recipientId
            ]);

        Notification::factory()
            ->create([
                'recipient_id' => ($recipientId + 1)
            ]);

        $generatedNotificationsAsArray = $generatedNotifications->toArray();

        $notifications = $this->getRecipientNotificationListService->execute($recipientId);
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
    public function test_should_get_empty_list_if_data_not_exists(): void
    {
        $recipientId = 99;

        $notifications = $this->getRecipientNotificationListService->execute($recipientId);
        $this->assertCount(0, $notifications);
    }
}
