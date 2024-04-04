<?php

declare(strict_types=1);

namespace App\Posts\Infrastructure\Adapter;

use App\Posts\Domain\ValueObject\Author;

readonly class UserAdapter
{
    public function __construct(private UserApiInterface $api) {}

    public function getAuthorById(string $id): ?Author
    {
        return $this->makeAuthorFromDTO(
            $this->api->getById($id)
        );
    }

    public function createFakeAuthor(): Author
    {
        return $this->makeAuthorFromDTO(
            $this->api->createFake()
        );
    }

    private function makeAuthorFromDTO(?UserDTOInterface $userDTO): ?Author
    {
        if (!$userDTO) {
            return null;
        }

        return new Author($userDTO->getId(), $userDTO->getName());
    }
}
