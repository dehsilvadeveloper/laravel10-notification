<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'recipient_id' => $this->recipient_id,
            'content' => $this->content,
            'category' => $this->category,
            'read_at' => $this->read_at?->format('Y-m-d H:i:s'),
            'canceled_at' => $this->canceled_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at'=> $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
}
