<?php

declare(strict_types=1);

namespace App\Posts\Application\Factory;

use App\Posts\Domain\ValueObject\Author;
use Faker\Generator;

class AuthorFakeFactory
{
    public function __construct(private readonly Generator $faker)
    {
    }

    public function create(?string $id = null, ?string $name = null): Author
    {
        if (!$id) {
            $id = $this->faker->uuid();
        }

        if (!$name) {
            $name = $this->faker->name();
        }

        return new Author($id, $name);
    }
}