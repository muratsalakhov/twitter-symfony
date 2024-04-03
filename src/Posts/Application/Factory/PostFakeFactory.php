<?php

declare(strict_types=1);

namespace App\Posts\Application\Factory;

use App\Posts\Domain\Aggregate\Post;
use App\Posts\Domain\Factory\PostFactory;
use App\Posts\Domain\ValueObject\Author;
use Faker\Generator;

class PostFakeFactory
{
    public function __construct(
        private readonly PostFactory $postFactory,
        private readonly Generator $faker,
        private readonly AuthorFakeFactory $authorFakeFactory
    ) {
    }

    public function create(?string $text = null, ?Author $author = null): Post
    {
        if (!$text) {
            $text = $this->faker->text(100);
        }

        if (!$author) {
            $author = $this->authorFakeFactory->create();
        }

        return $this->postFactory->create($text, $author);
    }
}