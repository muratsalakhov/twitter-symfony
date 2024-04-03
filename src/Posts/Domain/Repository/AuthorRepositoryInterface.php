<?php

declare(strict_types=1);

namespace App\Posts\Domain\Repository;

use App\Posts\Domain\ValueObject\Author;

interface AuthorRepositoryInterface
{
    public function findById(string $id): ?Author;
}