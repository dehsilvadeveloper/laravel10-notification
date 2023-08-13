<?php

namespace Tests\Unit\Services\Notification;

use App\Models\Notification;
use App\Services\Interfaces\Notification\GetRecipientNotificationCountServiceInterface;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class GetRecipientNotificationCountServiceTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @var GetRecipientNotificationCountServiceInterface */
    private $getRecipientNotificationCountService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->getRecipientNotificationCountService = app(GetRecipientNotificationCountServiceInterface::class);
    }

    /**
     * @group NotificationService
     */
    public function test_should_get_count(): void
    {
        $notificationCount = 5;
        $recipientId = 7;

        Notification::factory()
            ->count($notificationCount)
            ->create([
                'recipient_id' => $recipientId
            ]);

        Notification::factory()
            ->create([
                'recipient_id' => ($recipientId + 1)
            ]);

        $result = $this->getRecipientNotificationCountService->execute($recipientId);

        $this->assertEquals($notificationCount, $result);
    }

    /**
     * @group NotificationService
     */
    public function test_should_count_zero_if_data_not_exists(): void
    {
        $recipientId = 99;

        $result = $this->getRecipientNotificationCountService->execute($recipientId);
        $this->assertEquals(0, $result);
    }
}
