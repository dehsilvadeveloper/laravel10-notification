<?php

namespace Tests\Unit\Services\Notification;

use App\Exceptions\NotificationNotFoundException;
use App\Models\Notification;
use App\Services\Interfaces\Notification\GetNotificationServiceInterface;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class GetNotificationServiceTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @var GetNotificationServiceInterface */
    private $getNotificationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->getNotificationService = app(GetNotificationServiceInterface::class);
    }

    /**
     * @group NotificationService
     */
    public function test_should_get(): void
    {
        $generatedNotification = Notification::factory()->create();

        $notification = $this->getNotificationService->execute($generatedNotification->id);

        $this->assertInstanceOf(Notification::class, $notification);
        $this->assertEquals($generatedNotification->id, $notification->id);
        $this->assertEquals($generatedNotification->recipient_id, $notification->recipient_id);
        $this->assertEquals($generatedNotification->content, $notification->content);
        $this->assertEquals($generatedNotification->category, $notification->category);
        $this->assertNull($notification->read_at);
        $this->assertNull($notification->canceled_at);
    }

    /**
     * @group NotificationService
     */
    public function test_should_fail_to_get_non_existing_notification(): void
    {
        $this->expectException(NotificationNotFoundException::class);
        $this->expectExceptionMessage('Notification not found');

        $latestNotification = Notification::orderBy('id', 'DESC')->first();
        $nonExistentId = $latestNotification ? ($latestNotification->id + 1) : 1;

        $notification = $this->getNotificationService->execute($nonExistentId);
    }
}
