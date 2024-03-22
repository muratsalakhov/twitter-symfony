<?php

declare(strict_types=1);

namespace App\Users\Application\Factory;

use App\Users\Domain\Entity\User;
use App\Users\Domain\Factory\UserFactory;
use Faker\Generator;

class UserFakeFactory
{
    public function __construct(
        private readonly UserFactory $userFactory,
        private readonly Generator $faker
    ) {
    }

    public function create(?string $name = null, ?string $email = null, ?string $password = null): User
    {
        if (!$name) {
            $name = $this->faker->name();
        }

        if (!$email) {
            $email = $this->faker->email();
        }

        if (!$password) {
            $password = $this->faker->password();
        }

        return $this->userFactory->create($name, $email, $password);
    }
}