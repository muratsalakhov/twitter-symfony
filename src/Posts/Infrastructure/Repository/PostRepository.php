<?php

declare(strict_types=1);

namespace App\Posts\Infrastructure\Repository;

use App\Posts\Domain\Aggregate\Post;
use App\Posts\Domain\Repository\PostRepositoryInterface;
use App\Posts\Infrastructure\Adapter\UserAdapter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PostRepository extends ServiceEntityRepository implements PostRepositoryInterface
{
    private UserAdapter $userAdapter;

    public function __construct(ManagerRegistry $registry, UserAdapter $userAdapter)
    {
        parent::__construct($registry, Post::class);

        $this->userAdapter = $userAdapter;
    }

    public function add(Post $post): void
    {
        $this->getEntityManager()->persist($post);
        $this->getEntityManager()->flush();
    }

    public function findById(string $id): ?Post
    {
        $post = $this->find($id);

        if ($post) {
            $author = $this->userAdapter->getAuthorById($post->getAuthorId());
            $post->setAuthor($author);
        }

        return $post;
    }

    public function findAllByAuthor(string $authorId): array
    {
        return $this->findBy(['authorId' => $authorId]);
    }
}