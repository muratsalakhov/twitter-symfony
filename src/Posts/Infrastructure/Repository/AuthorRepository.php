<?php

declare(strict_types=1);

namespace App\Posts\Infrastructure\Repository;

use App\Posts\Domain\Repository\AuthorRepositoryInterface;
use App\Posts\Domain\ValueObject\Author;
use App\Posts\Infrastructure\Adapter\UserAdapter;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function __construct(private readonly UserAdapter $userAdapter) {}

    public function findById(string $id): ?Author
    {
        $userDTO = $this->userAdapter->getAuthorById($id);

        if (!$userDTO) {
            return null;
        }

        return new Author($userDTO->getId(), $userDTO->getName());
    }
}
