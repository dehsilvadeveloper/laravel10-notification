<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'current_page' => $this->currentPage(),
            'last_page' => $this->lastPage(),
            'per_page' => $this->perPage(),
            'from' => $this->firstItem(),
            'to' => $this->lastItem(),
            'total' => $this->total(),
            'path' => $this->path(),
            'first_page_url' => $this->url(1),
            'prev_page_url' => $this->previousPageUrl(),
            'next_page_url' => $this->nextPageUrl(),
            'last_page_url' => $this->url($this->lastPage())
        ];
    }

    public function withResponse($request, $response): void
    {
        $jsonResponse = json_decode($response->getContent(), true);

        unset($jsonResponse['links'], $jsonResponse['meta']);

        $response->setContent(json_encode($jsonResponse));
    }
}
