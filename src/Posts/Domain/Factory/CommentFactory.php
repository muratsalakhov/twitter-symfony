<?php

declare(strict_types=1);

namespace App\Posts\Domain\Factory;

use App\Posts\Domain\Aggregate\Post;
use App\Posts\Domain\Entity\Comment;
use App\Posts\Domain\ValueObject\Author;

class CommentFactory
{
    public function create(string $text, Author $author, Post $post): Comment
    {
        return new Comment($text, $author, $post);
    }
}
