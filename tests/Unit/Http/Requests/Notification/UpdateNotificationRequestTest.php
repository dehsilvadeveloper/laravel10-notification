<?php

namespace Tests\Unit\Http\Requests\Notification;

use App\Enums\NotificationCategoryEnum;
use App\Http\Requests\Notification\UpdateNotificationRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UpdateNotificationRequestTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @group NotificationFormRequest
     */
    public function test_valid_request_passes(): void
    {
        $data = [
            'recipient_id' => 1,
            'content' => fake()->sentence(),
            'category' => NotificationCategoryEnum::SOCIAL->value,
        ];

        $request = (new UpdateNotificationRequest())->replace($data);
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->fails());
    }

    /**
     * @group NotificationFormRequest
     */
    public function test_nullable_fields_pass(): void
    {
        $data = [];

        $request = (new UpdateNotificationRequest())->replace($data);
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->fails());
    }

    /**
     * @group NotificationFormRequest
     */
    public function test_invalid_recipient_id_fail(): void
    {
        $data = [
            'recipient_id' => 'invalid_id',
            'content' => fake()->sentence(),
            'category' => NotificationCategoryEnum::SOCIAL->value,
        ];

        $request = (new UpdateNotificationRequest())->replace($data);
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertCount(2, $validator->errors());
        $this->assertTrue($validator->errors()->has('recipient_id'));

        $expectedMessages = [
            'The recipient id field must be an integer.',
            'The recipient id field must be greater than 0.',
        ];

        $this->assertEquals(
            $expectedMessages,
            $validator->errors()->get('recipient_id')
        );
    }

    /**
     * @group NotificationFormRequest
     */
    public function test_recipient_id_not_greater_than_value_fail(): void
    {
        $data = [
            'recipient_id' => 0,
            'content' => fake()->sentence(),
            'category' => NotificationCategoryEnum::SOCIAL->value,
        ];

        $request = (new UpdateNotificationRequest())->replace($data);
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->errors());
        $this->assertTrue($validator->errors()->has('recipient_id'));
        $this->assertEquals(
            'The recipient id field must be greater than 0.',
            $validator->errors()->first('recipient_id')
        );
    }

    /**
     * @group NotificationFormRequest
     */
    public function test_content_min_length_fail(): void
    {
        $data = [
            'recipient_id' => 1,
            'content' => 'ab',
            'category' => NotificationCategoryEnum::SOCIAL->value,
        ];

        $request = (new UpdateNotificationRequest())->replace($data);
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->errors());
        $this->assertTrue($validator->errors()->has('content'));
        $this->assertEquals(
            'The content field must be at least 3 characters.',
            $validator->errors()->first('content')
        );
    }

    /**
     * @group NotificationFormRequest
     */
    public function test_category_invalid_enum_value_fail(): void
    {
        $data = [
            'recipient_id' => 1,
            'content' => fake()->sentence(),
            'category' => 'invalid_category',
        ];

        $request = (new UpdateNotificationRequest())->replace($data);
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->errors());
        $this->assertTrue($validator->errors()->has('category'));
        $this->assertEquals(
            'The selected category is invalid.',
            $validator->errors()->first('category')
        );
    }
}
