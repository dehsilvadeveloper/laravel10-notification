<?php

namespace App\Http\Requests\Notification;

use Illuminate\Foundation\Http\FormRequest;

class GetNotificationPaginatedListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'page' => ['nullable', 'integer', 'gt:0'],
            'page_size' => ['nullable', 'integer', 'between:1,100']
        ];
    }

    public function queryParameters()
    {
        return [
            'page' => [
                'description' => 'The page number of pagination',
                'example' => 1
            ],
            'page_size' => [
                'description' => 'The quantity of items (page size) of pagination.',
                'example' => 10
            ],
        ];
    }
}
