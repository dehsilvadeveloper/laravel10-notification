<?php

namespace App\Traits\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait HttpResponses
{
    /**
     * @param $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    protected function sendErrorResponse(
        string $message,
        array $data = [],
        ?int $code = null
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
