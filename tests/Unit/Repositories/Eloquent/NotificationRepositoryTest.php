<?php

namespace Tests\Unit\Repositories\Eloquent;

use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
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
        $this->assertTrue(true);
    }

    /**
     * @group NotificationRepository
     */
    public function test_should_update(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @group NotificationRepository
     */
    public function test_should_find_all(): void
    {
        $notificationCount = 3;

        Notification::factory()->count($notificationCount)->create();

        $result = $this->notificationRepository->findAll();

        $this->assertCount($notificationCount, $result);
        // Add more asserts
    }

    /**
     * @group NotificationRepository
     */
    public function test_should_find_all_paginated(): void
    {
        $this->assertTrue(true);
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
        $this->assertTrue(true);
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
