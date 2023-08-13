<?php

namespace App\Traits\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait HttpResponses
{
    protected function sendErrorResponse(
        string $message,
        ?int $code = null,
        array $data = []
    ): JsonResponse {
        if (!array_key_exists($code, Response::$statusTexts)) {
            $code = Response::HTTP_BAD_REQUEST;
        }

        return response()->json([
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
