<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Api;

use App\Posts\Infrastructure\Adapter\UserApiInterface;
use App\Posts\Infrastructure\Adapter\UserDTOInterface;
use App\Users\Application\Factory\UserFakeFactory;
use App\Users\Infrastructure\Repository\UserRepository;

final readonly class PostsUserApi implements UserApiInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private UserFakeFactory $userFakeFactory
    ) {}

    public function getById(string $id): ?UserDTOInterface
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            return null;
        }

        return new PostsUserDTO($user->getUlid(), $user->getName());
    }

    public function createFake(): UserDTOInterface
    {
        $fakeUser = $this->userFakeFactory->create();
        $this->userRepository->add($fakeUser);

        return new PostsUserDTO($fakeUser->getUlid(), $fakeUser->getName());
    }
}
