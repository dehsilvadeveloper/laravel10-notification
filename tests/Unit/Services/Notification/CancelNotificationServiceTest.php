<?php

namespace Tests\Unit\Services\Notification;

use App\Exceptions\NotificationNotFoundException;
use App\Models\Notification;
use App\Services\Interfaces\Notification\CancelNotificationServiceInterface;
use DateTime;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class CancelNotificationServiceTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @var CancelNotificationServiceInterface */
    private $cancelNotificationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cancelNotificationService = app(CancelNotificationServiceInterface::class);
    }

    /**
     * @group NotificationService
     */
    public function test_should_cancel(): void
    {
        $notification = Notification::factory()->create();

        $canceledNotification = $this->cancelNotificationService->execute($notification->id);

        $this->assertNotNull($canceledNotification->canceled_at);
        $this->assertInstanceOf(DateTime::class, $canceledNotification->canceled_at);
    }

    /**
     * @group NotificationService
     */
    public function test_should_fail_to_cancel_non_existing_notification(): void
    {
        $this->expectException(NotificationNotFoundException::class);
        $this->expectExceptionMessage('Notification not found');

        $nonExistentId = 9999;

        $canceledNotification = $this->cancelNotificationService->execute($nonExistentId);
    }
}
