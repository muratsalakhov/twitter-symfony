<?php

declare(strict_types=1);

namespace App\Users\Domain\Factory;

use App\Users\Domain\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function create(string $name, string $email, string $password): User
    {
        $user = new User($name, $email);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        return $user;
    }
}