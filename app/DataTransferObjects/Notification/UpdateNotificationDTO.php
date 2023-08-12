<?php

namespace App\DataTransferObjects\Notification;

use App\DataTransferObjects\BaseDataTransferObject;
use App\DataTransferObjects\Interfaces\DataTransferObjectInterface;
use App\Enums\NotificationCategoryEnum;
use Illuminate\Http\Request;

class UpdateNotificationDTO extends BaseDataTransferObject implements DataTransferObjectInterface
{
    public function __construct(
        public readonly ?int $recipientId,
        public readonly ?string $content,
        public readonly ?NotificationCategoryEnum $category
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            recipientId: $request->validated('recipient_id'),
            content: $request->validated('content'),
            category: $request->filled('category')
                ? NotificationCategoryEnum::from($request->validated('category'))
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
