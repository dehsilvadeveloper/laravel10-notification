<?php

namespace App\DataTransferObjects\Notification;

use App\DataTransferObjects\BaseDataTransferObject;
use App\Enums\NotificationCategoryEnum;
use Illuminate\Http\Request;

class CreateNotificationDTO extends BaseDataTransferObject
{
    public function __construct(
        public readonly int $recipientId,
        public readonly string $content,
        public readonly NotificationCategoryEnum $category
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            recipientId: $request->input('recipient_id'),
            content: $request->input('content'),
            category: $request->filled('category')
                ? NotificationCategoryEnum::from($request->input('category'))
                : null
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            recipientId: $data['recipient_id'] ?? null,
            content: $data['content'] ?? null,
            category: isset($data['category'])
                ? NotificationCategoryEnum::from($data['category'])
                : null
        );
    }
}