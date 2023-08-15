<?php

namespace Tests\Unit\Http\Requests\Notification;

use App\Http\Requests\Notification\GetNotificationPaginatedListRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class GetNotificationPaginatedListRequestTest extends TestCase
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
            'page' => 1,
            'page_size' => 30
        ];

        $request = (new GetNotificationPaginatedListRequest())->replace($data);
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->fails());
    }

    /**
     * @group NotificationFormRequest
     */
    public function test_nullable_fields_pass(): void
    {
        $data = [];

        $request = (new GetNotificationPaginatedListRequest())->replace($data);
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->fails());
    }

    /**
     * @group NotificationFormRequest
     */
    public function test_invalid_page_fail(): void
    {
        $data = [
            'page' => 'invalid_page',
            'page_size' => 10
        ];

        $request = (new GetNotificationPaginatedListRequest())->replace($data);
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertCount(2, $validator->errors());
        $this->assertTrue($validator->errors()->has('page'));

        $expectedMessages = [
            'The page field must be an integer.',
            'The page field must be greater than 0.',
        ];

        $this->assertEquals(
            $expectedMessages,
            $validator->errors()->get('page')
        );
    }

    /**
     * @group NotificationFormRequest
     */
    public function test_page_not_greater_than_value_fail(): void
    {
        $data = [
            'page' => 0,
            'page_size' => 10
        ];

        $request = (new GetNotificationPaginatedListRequest())->replace($data);
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->errors());
        $this->assertTrue($validator->errors()->has('page'));
        $this->assertEquals(
            'The page field must be greater than 0.',
            $validator->errors()->first('page')
        );
    }

    /**
     * @group NotificationFormRequest
     */
    public function test_invalid_page_size_fail(): void
    {
        $data = [
            'page' => 1,
            'page_size' => 'invalid_page_size'
        ];

        $request = (new GetNotificationPaginatedListRequest())->replace($data);
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->errors());
        $this->assertTrue($validator->errors()->has('page_size'));

        $expectedMessages = [
            'The page size field must be an integer.'
        ];

        $this->assertEquals(
            $expectedMessages,
            $validator->errors()->get('page_size')
        );
    }

    /**
     * @group NotificationFormRequest
     */
    public function test_page_size_with_value_not_allowed_fail(): void
    {
        $data = [
            'page' => 1,
            'page_size' => 101
        ];

        $request = (new GetNotificationPaginatedListRequest())->replace($data);
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->errors());
        $this->assertTrue($validator->errors()->has('page_size'));
        $this->assertEquals(
            'The page size field must be between 1 and 100.',
            $validator->errors()->first('page_size')
        );
    }
}
