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

        $notificationData = Notification::factory()->count($notificationCount)->create();
        $notificationDataAsArray = $notificationData->toArray();

        $result = $this->notificationRepository->findAll();
        $resultAsArray = $result->toArray();

        $this->assertCount($notificationCount, $result);

        for ($i = 0; $i <= ($notificationCount - 1); $i++) {
            $this->assertEquals($notificationDataAsArray[$i]['recipient_id'], $resultAsArray[$i]['recipient_id']);
            $this->assertEquals($notificationDataAsArray[$i]['content'], $resultAsArray[$i]['content']);
            $this->assertEquals($notificationDataAsArray[$i]['category'], $resultAsArray[$i]['category']);
            $this->assertEquals($notificationDataAsArray[$i]['created_at'], $resultAsArray[$i]['created_at']);
            $this->assertEquals($notificationDataAsArray[$i]['updated_at'], $resultAsArray[$i]['updated_at']);
        }
    }

    /**
     * @group NotificationRepository
     */
    public function test_should_find_all_paginated(): void
    {
        $notificationCount = 20;
        $pageSize = 10;
        $page = 2;

        $notificationData = Notification::factory()->count($notificationCount)->create();
        $notificationDataAsArray = $notificationData->toArray();

        $result = $this->notificationRepository->findAllPaginated($page, $pageSize);
        $resultAsArray = $result->toArray();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals($notificationCount, $resultAsArray['total']);
        $this->assertEquals($pageSize, $resultAsArray['per_page']);
        $this->assertEquals($page, $resultAsArray['current_page']);
        $this->assertEquals($notificationDataAsArray[10]['recipient_id'], $resultAsArray['data'][0]['recipient_id']);
        $this->assertEquals($notificationDataAsArray[10]['content'], $resultAsArray['data'][0]['content']);
        $this->assertEquals($notificationDataAsArray[10]['category'], $resultAsArray['data'][0]['category']);
        $this->assertEquals($notificationDataAsArray[10]['created_at'], $resultAsArray['data'][0]['created_at']);
        $this->assertEquals($notificationDataAsArray[10]['updated_at'], $resultAsArray['data'][0]['updated_at']);
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

        $notificationData = Notification::factory()
            ->count($notificationCount)
            ->create([
                'recipient_id' => $recipientId
            ]);

        Notification::factory()
            ->create([
                'recipient_id' => ($recipientId + 1)
            ]);

        $notificationDataAsArray = $notificationData->toArray();

        $result = $this->notificationRepository->findManyByRecipientId($recipientId);
        $resultAsArray = $result->toArray();

        for ($i = 0; $i <= ($notificationCount - 1); $i++) {
            $this->assertEquals($notificationDataAsArray[$i]['recipient_id'], $resultAsArray[$i]['recipient_id']);
            $this->assertEquals($notificationDataAsArray[$i]['content'], $resultAsArray[$i]['content']);
            $this->assertEquals($notificationDataAsArray[$i]['category'], $resultAsArray[$i]['category']);
            $this->assertEquals($notificationDataAsArray[$i]['created_at'], $resultAsArray[$i]['created_at']);
            $this->assertEquals($notificationDataAsArray[$i]['updated_at'], $resultAsArray[$i]['updated_at']);
        }
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
}
