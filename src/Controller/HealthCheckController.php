<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HealthCheckController
{
    #[Route('/healthcheck', name: 'healthcheck', methods: ['GET'])]
    public function index(): Response
    {
        return new JsonResponse(['status' => 'ok']);
    }
}