<?php

namespace Tests\Unit\DataTransferObjects;

use App\DataTransferObjects\Notification\CreateNotificationDTO;
use App\Enums\NotificationCategoryEnum;
use Illuminate\Http\Request;
use Tests\TestCase;
use TypeError;

class CreateNotificationDTOTest extends TestCase
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

        $dto = CreateNotificationDTO::fromArray($data);
        $dtoAsArray = $dto->toArray();

        $this->assertInstanceOf(CreateNotificationDTO::class, $dto);
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

        $dto = CreateNotificationDTO::fromRequest($request);
        $dtoAsArray = $dto->toArray();

        $this->assertInstanceOf(CreateNotificationDTO::class, $dto);
        $this->assertEquals(1, $dtoAsArray['recipient_id']);
        $this->assertEquals($requestData['content'], $dtoAsArray['content']);
        $this->assertEquals(NotificationCategoryEnum::PROFESSIONAL, $dtoAsArray['category']);
    }

    /**
     * @group NotificationDTO
     */
    public function test_should_throw_exception_if_creating_from_empty_array(): void
    {
        $this->expectException(TypeError::class);

        CreateNotificationDTO::fromArray([]);
    }

    /**
     * @group NotificationDTO
     */
    public function test_should_throw_exception_if_creating_from_empty_request(): void
    {
        $this->expectException(TypeError::class);

        $request = Request::create('/dummy', 'POST', []);

        CreateNotificationDTO::fromRequest($request);
    }
}
