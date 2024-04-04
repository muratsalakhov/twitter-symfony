<?php

declare(strict_types=1);

namespace App\Posts\Domain\Factory;

use App\Posts\Domain\Aggregate\Post;
use App\Posts\Domain\ValueObject\Author;

class PostFactory
{
    public function create(string $text, Author $author): Post
    {
        return new Post($text, $author);
    }
}
