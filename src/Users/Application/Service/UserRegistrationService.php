<?php

declare(strict_types=1);

namespace App\Users\Application\Service;

use App\Users\Application\Exception\UserRegistrationException;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Domain\Repository\UserRepositoryInterface;

class UserRegistrationService implements UserRegistrationServiceInterface
{
    public function __construct(private UserRepositoryInterface $userRepository, private UserFactory $userFactory) {}

    /**
     * @throws UserRegistrationException
     */
    public function register(string $name, string $email, string $password): User
    {
        // проверяем, свободен ли email
        if ($this->userRepository->findByEmail($email)) {
            throw new UserRegistrationException('User with email already exists');
        }

        // cоздаем пользователя с помощью фабрики
        $user = $this->userFactory->create($name, $email, $password);

        // cохраняем пользователя в базе данных
        $this->userRepository->add($user);

        return $user;
    }
}
