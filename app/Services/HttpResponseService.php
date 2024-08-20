<?php

namespace App\Services;

use App\Contracts\HttpResponseInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HttpResponseService implements HttpResponseInterface
{
    public function success(string $message = 'Request processed successfully', array $data = [], int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function error(string $message = 'Request Processing failed', array $errors = [], int $code = Response::HTTP_FORBIDDEN): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}
