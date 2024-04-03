<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Api;

use App\Posts\Infrastructure\Adapter\UserApiInterface;
use App\Posts\Infrastructure\Adapter\UserDTOInterface;
use App\Users\Infrastructure\Repository\UserRepository;

final readonly class PostsUserApi implements UserApiInterface
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function getById(string $id): ?UserDTOInterface
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            return null;
        }

        return new PostsUserDTO($user->getId, $user->getName());
    }
}