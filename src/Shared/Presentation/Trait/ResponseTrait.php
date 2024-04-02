<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Trait;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ResponseTrait
{
    protected function success($data, int $status = Response::HTTP_OK, array $headers = []): JsonResponse
    {
        return $this->json([
            'success' => true,
            'data' => $data,
        ], $status, $headers);
    }

    protected function error($message, int $status = Response::HTTP_BAD_REQUEST, array $headers = []): JsonResponse
    {
        return $this->json([
            'success' => false,
            'error' => [
                'message' => $message,
                'code' => $status,
            ],
        ], $status, $headers);
    }
}
