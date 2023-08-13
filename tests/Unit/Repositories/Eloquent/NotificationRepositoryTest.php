<?php

namespace Tests\Unit\Repositories\Eloquent;

use App\DataTransferObjects\Notification\CreateNotificationDTO;
use App\DataTransferObjects\Notification\UpdateNotificationDTO;
use App\Enums\NotificationCategoryEnum;
use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class NotificationRepositoryTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @var NotificationRepositoryInterface */
    private $notificationRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->notificationRepository = app(NotificationRepositoryInterface::class);
    }

    /**
     * @group NotificationRepository
     */
    public function test_should_create(): void
    {
        $data = [
            'recipient_id' => 1,
            'content' => fake()->sentence(),
            'category' => fake()->randomElement(NotificationCategoryEnum::class)->value
        ];

        $createdNotification = $this->notificationRepository->create(
            CreateNotificationDTO::fromArray($data)
        );

        $this->assertInstanceOf(Notification::class, $createdNotification);
        $this->assertDatabaseHas('notifications', $data);
    }

    /**
     * @group NotificationRepository
     */
    public function test_should_update(): void
    {
        $existingNotification = Notification::factory()->create([
            'content' => 'initial content',
            'category' => NotificationCategoryEnum::SOCIAL
        ]);

        $dataForUpdate = [
            'content' => 'Updated content',
            'category' => NotificationCategoryEnum::PROFESSIONAL->value
        ];

        $updatedNotification = $this->notificationRepository->update(
            $existingNotification->id,
            UpdateNotificationDTO::fromArray($dataForUpdate)
        );

        $this->assertInstanceOf(Notification::class, $updatedNotification);
        $this->assertEquals($existingNotification->recipient_id, $updatedNotification->recipient_id);
        $this->assertEquals($dataForUpdate['content'], $updatedNotification->content);
        $this->assertEquals(NotificationCategoryEnum::PROFESSIONAL, $updatedNotification->category);
    }

    /**
     * @group NotificationRepository
     */
    public function test_should_find_all(): void
    {
        $notificationCount = 3;

        $generatedNotifications = Notification::factory()->count($notificationCount)->create();
        $generatedNotificationsAsArray = $generatedNotifications->toArray();

        $notifications = $this->notificationRepository->findAll();
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
     * @group NotificationRepository
     */
    public function test_should_get_empty_list_if_data_not_exists(): void
    {
        $notifications = $this->notificationRepository->findAll();
        $this->assertCount(0, $notifications);
    }

    /**
     * @group NotificationRepository
     */
    public function test_should_find_all_paginated(): void
    {
        $notificationCount = 20;
        $pageSize = 10;
        $page = 2;

        $generatedNotifications = Notification::factory()->count($notificationCount)->create();
        $generatedNotificationsAsArray = $generatedNotifications->toArray();

        $notifications = $this->notificationRepository->findAllPaginated($page, $pageSize);
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
     * @group NotificationRepository
     */
    public function test_should_get_empty_paginated_list_if_data_not_exists(): void
    {
        $pageSize = 10;
        $page = 1;

        $notifications = $this->notificationRepository->findAllPaginated($page, $pageSize);
        $notificationsAsArray = $notifications->toArray();

        $this->assertEquals(0, $notificationsAsArray['total']);
        $this->assertEquals($pageSize, $notificationsAsArray['per_page']);
        $this->assertEquals($page, $notificationsAsArray['current_page']);
        $this->assertEmpty($notificationsAsArray['data']);
    }

    /**
     * @group NotificationRepository
     */
    public function test_should_find_by_id(): void
    {
        $notification = Notification::factory()->create();

        $result = $this->notificationRepository->findById($notification->id);

        $this->assertInstanceOf(Notification::class, $result);
        $this->assertEquals($notification->id, $result->id);
        $this->assertEquals($notification->recipient_id, $result->recipient_id);
        $this->assertEquals($notification->content, $result->content);
        $this->assertEquals($notification->category, $result->category);
        $this->assertNull($result->read_at);
        $this->assertNull($result->canceled_at);
    }

    /**
     * @group NotificationRepository
     */
    public function test_should_delete_by_id(): void
    {
        $notification = Notification::factory()->create();

        $this->notificationRepository->deleteById($notification->id);

        $this->assertDatabaseMissing('notifications', ['id' => $notification->id]);
    }

    /**
     * @group NotificationRepository
     */
    public function test_should_find_many_by_recipient_id(): void
    {
        $notificationCount = 5;
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

        $notifications = $this->notificationRepository->findManyByRecipientId($recipientId);
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
     * @group NotificationRepository
     */
    public function test_should_get_empty_list_by_recipient_id_if_data_not_exists(): void
    {
        $recipientId = 99;

        $notifications = $this->notificationRepository->findManyByRecipientId($recipientId);
        $this->assertCount(0, $notifications);
    }

    /**
     * @group NotificationRepository
     */
    public function test_should_count_by_recipient_id(): void
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

        $result = $this->notificationRepository->countByRecipientId($recipientId);

        $this->assertEquals($notificationCount, $result);
    }

    /**
     * @group NotificationRepository
     */
    public function test_should_count_zero_by_recipient_id_if_data_not_exists(): void
    {
        $recipientId = 99;

        $result = $this->notificationRepository->countByRecipientId($recipientId);
        $this->assertEquals(0, $result);
    }
}
