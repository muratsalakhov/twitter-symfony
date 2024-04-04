<?php

declare(strict_types=1);

namespace App\Posts\Domain\Repository;

use App\Posts\Domain\Aggregate\Post;
use App\Posts\Domain\Entity\Comment;
use Doctrine\Common\Collections\ArrayCollection;

interface CommentRepositoryInterface
{
    public function add(Comment $comment): void;

    public function findById(string $id): ?Comment;

    public function findByPost(Post $post): ArrayCollection;
}