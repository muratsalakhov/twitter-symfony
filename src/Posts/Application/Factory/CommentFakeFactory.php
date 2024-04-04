<?php

declare(strict_types=1);

namespace App\Posts\Application\Factory;

use App\Posts\Domain\Aggregate\Post;
use App\Posts\Domain\Entity\Comment;
use App\Posts\Domain\Factory\CommentFactory;
use App\Posts\Domain\ValueObject\Author;
use Faker\Generator;

class CommentFakeFactory
{
    public function __construct(
        private CommentFactory $commentFactory,
        private Generator $faker,
        private AuthorFakeFactory $authorFakeFactory,
        private PostFakeFactory $postFakeFactory
    ) {
    }

    public function create(?string $text = null, ?Author $author = null, ?Post $post = null): Comment
    {
        if (!$text) {
            $text = $this->faker->text(100);
        }

        if (!$author) {
            $author = $this->authorFakeFactory->create();
        }

        if (!$post) {
            $post = $this->postFakeFactory->create();
        }

        return $this->commentFactory->create($text, $author, $post);
    }
}
