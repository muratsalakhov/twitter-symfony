<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Api;

use App\Posts\Infrastructure\Adapter\UserDTOInterface;

final readonly class PostsUserDTO implements UserDTOInterface
{
    public function __construct(
        public string $id,
        public string $name
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
