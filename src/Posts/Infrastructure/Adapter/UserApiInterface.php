<?php

declare(strict_types=1);

namespace App\Posts\Infrastructure\Adapter;

interface UserApiInterface
{
    public function getById(string $id): ?UserDTOInterface;

    public function createFake(): UserDTOInterface;
}