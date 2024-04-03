<?php

declare(strict_types=1);

namespace App\Posts\Infrastructure\Adapter;

readonly class UserAdapter
{
    public function __construct(private UserApiInterface $api)
    {
    }

    public function getAuthorById(string $id): ?UserDTOInterface
    {
        return $this->api->getById($id);
    }
}