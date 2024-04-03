<?php

declare(strict_types=1);

namespace App\Posts\Domain\Repository;

use App\Posts\Domain\Aggregate\Post;

interface PostRepositoryInterface
{
    public function add(Post $post): void;

    public function findById(string $id): ?Post;

    public function findAllByAuthor(string $authorId): array;
}