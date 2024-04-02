<?php

declare(strict_types=1);

namespace App\Users\Application\Service;

use App\Users\Domain\Entity\User;

interface UserRegistrationServiceInterface
{
    public function register(string $name, string $email, string $password): User;
}
