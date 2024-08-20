<?php

namespace App\Contracts;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

interface HttpResponseInterface
{
    public function success(string $message, array $data, int $code = Response::HTTP_OK): JsonResponse;

    public function error(string $message, array $errors, int $code = Response::HTTP_FORBIDDEN): JsonResponse;
}
