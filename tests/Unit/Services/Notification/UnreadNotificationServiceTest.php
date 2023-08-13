<?php

namespace Tests\Unit\Services\Notification;

use App\Exceptions\NotificationNotFoundException;
use App\Models\Notification;
use App\Services\Interfaces\Notification\UnreadNotificationServiceInterface;
use DateTime;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class UnreadNotificationServiceTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @var UnreadNotificationServiceInterface */
    private $unreadNotificationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->unreadNotificationService = app(UnreadNotificationServiceInterface::class);
    }

    /**
     * @group NotificationService
     */
    public function test_should_unread(): void
    {
        $notification = Notification::factory()->create();

        $unreadNotification = $this->unreadNotificationService->execute($notification->id);

        $this->assertNull($unreadNotification->read_at);
    }

    /**
     * @group NotificationService
     */
    public function test_should_fail_to_unread_non_existing_notification(): void
    {
        $this->expectException(NotificationNotFoundException::class);
        $this->expectExceptionMessage('Notification not found');

        $latestNotification = Notification::orderBy('id', 'DESC')->first();
        $nonExistentId = $latestNotification ? ($latestNotification->id + 1) : 1;

        $unreadNotification = $this->unreadNotificationService->execute($nonExistentId);
    }
}
