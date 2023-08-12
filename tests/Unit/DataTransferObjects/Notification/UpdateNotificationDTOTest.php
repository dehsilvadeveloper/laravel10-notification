<?php

namespace Tests\Unit\DataTransferObjects\Notification;

use App\DataTransferObjects\Notification\UpdateNotificationDTO;
use App\Enums\NotificationCategoryEnum;
use App\Exceptions\EmptyDTOException;
use Illuminate\Http\Request;
use Tests\TestCase;

class UpdateNotificationDTOTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @group NotificationDTO
     */
    public function test_should_create_from_array(): void
    {
        $data = [
            'recipient_id' => 1,
            'content' => fake()->sentence(),
            'category' => NotificationCategoryEnum::SOCIAL->value
        ];

        $dto = UpdateNotificationDTO::fromArray($data);
        $dtoAsArray = $dto->toArray();

        $this->assertInstanceOf(UpdateNotificationDTO::class, $dto);
        $this->assertEquals(1, $dtoAsArray['recipient_id']);
        $this->assertEquals($data['content'], $dtoAsArray['content']);
        $this->assertEquals(NotificationCategoryEnum::SOCIAL, $dtoAsArray['category']);
    }

    /**
     * @group NotificationDTO
     */
    public function test_should_create_from_request(): void
    {
        $requestData = [
            'recipient_id' => 1,
            'content' => fake()->sentence(),
            'category' => NotificationCategoryEnum::PROFESSIONAL->value
        ];

        $request = Request::create('/dummy', 'POST', $requestData);

        $dto = UpdateNotificationDTO::fromRequest($request);
        $dtoAsArray = $dto->toArray();

        $this->assertInstanceOf(UpdateNotificationDTO::class, $dto);
        $this->assertEquals(1, $dtoAsArray['recipient_id']);
        $this->assertEquals($requestData['content'], $dtoAsArray['content']);
        $this->assertEquals(NotificationCategoryEnum::PROFESSIONAL, $dtoAsArray['category']);
    }

    /**
     * @group NotificationDTO
     */
    public function test_should_fail_if_creating_from_empty_array(): void
    {
        $this->expectException(EmptyDTOException::class);
        $this->expectExceptionMessage('The DTO has no properties to convert to array.');

        $dto = UpdateNotificationDTO::fromArray([]);
        $dtoAsArray = $dto->toArray();
    }

    /**
     * @group NotificationDTO
     */
    public function test_should_fail_if_creating_from_empty_request(): void
    {
        $this->expectException(EmptyDTOException::class);
        $this->expectExceptionMessage('The DTO has no properties to convert to array.');

        $request = Request::create('/dummy', 'POST', []);

        $dto = UpdateNotificationDTO::fromRequest($request);
        $dtoAsArray = $dto->toArray();
    }
}
