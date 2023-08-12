<?php

namespace App\Http\Requests\Notification;

use App\Enums\NotificationCategoryEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateNotificationRequest extends FormRequest
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
            'recipient_id' => ['nullable', 'integer', 'gt:0'],
            'content' => ['nullable', 'string', 'min:3'],
            'category' => ['nullable', 'string', new Enum(NotificationCategoryEnum::class)]
        ];
    }
}
