<?php

namespace App\Traits;

class CustomResponse
{
    static public function success($message, $data = [], $status = 200): JsonResponse
    {
        return response()->json(['message' => $message, 'data' => $data], $status);
    }

    static public function error($message, $status = 500): JsonResponse
    {
        return response()->json(['error' => $message], $status);
    }
}
