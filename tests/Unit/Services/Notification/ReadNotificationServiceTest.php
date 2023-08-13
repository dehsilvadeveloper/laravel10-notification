<?php

namespace Tests\Unit\Services\Notification;

use App\Exceptions\NotificationNotFoundException;
use App\Models\Notification;
use App\Services\Interfaces\Notification\ReadNotificationServiceInterface;
use DateTime;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ReadNotificationServiceTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @var ReadNotificationServiceInterface */
    private $readNotificationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->readNotificationService = app(ReadNotificationServiceInterface::class);
    }

    /**
     * @group NotificationService
     */
    public function test_should_read(): void
    {
        $notification = Notification::factory()->create();

        $readNotification = $this->readNotificationService->execute($notification->id);

        $this->assertNotNull($readNotification->read_at);
        $this->assertInstanceOf(DateTime::class, $readNotification->read_at);
    }

    /**
     * @group NotificationService
     */
    public function test_should_fail_to_read_non_existing_notification(): void
    {
        $this->expectException(NotificationNotFoundException::class);
        $this->expectExceptionMessage('Notification not found');

        $latestNotification = Notification::orderBy('id', 'DESC')->first();
        $nonExistentId = $latestNotification ? ($latestNotification->id + 1) : 1;

        $readNotification = $this->readNotificationService->execute($nonExistentId);
    }
}
