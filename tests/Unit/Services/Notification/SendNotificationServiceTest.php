<?php

namespace Tests\Unit\Services\Notification;

use App\DataTransferObjects\Notification\CreateNotificationDTO;
use App\Enums\NotificationCategoryEnum;
use App\Models\Notification;
use App\Services\Interfaces\Notification\SendNotificationServiceInterface;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class SendNotificationServiceTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @var SendNotificationServiceInterface */
    private $sendNotificationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sendNotificationService = app(SendNotificationServiceInterface::class);
    }

    /**
     * @group NotificationService
     */
    public function test_should_send(): void
    {
        $data = [
            'recipient_id' => 1,
            'content' => fake()->sentence(),
            'category' => fake()->randomElement(NotificationCategoryEnum::class)->value
        ];
        $dto = CreateNotificationDTO::fromArray($data);

        $createdNotification = $this->sendNotificationService->execute($dto);

        $this->assertInstanceOf(Notification::class, $createdNotification);
        $this->assertDatabaseHas('notifications', $data);
    }
}
