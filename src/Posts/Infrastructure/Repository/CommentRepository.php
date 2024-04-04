<?php

declare(strict_types=1);

namespace App\Posts\Infrastructure\Repository;

use App\Posts\Domain\Aggregate\Post;
use App\Posts\Domain\Entity\Comment;
use App\Posts\Domain\Repository\CommentRepositoryInterface;
use App\Posts\Infrastructure\Adapter\UserAdapter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

class CommentRepository extends ServiceEntityRepository implements CommentRepositoryInterface
{
    private UserAdapter $userAdapter;

    public function __construct(ManagerRegistry $registry, UserAdapter $userAdapter)
    {
        parent::__construct($registry, Comment::class);

        $this->userAdapter = $userAdapter;
    }

    public function add(Comment $comment): void
    {
        $this->getEntityManager()->persist($comment);
        $this->getEntityManager()->flush();
    }

    public function findById(string $id): ?Comment
    {
        $comment = $this->find($id);

        if ($comment) {
            $author = $this->userAdapter->getAuthorById($comment->getAuthorId());
            $comment->setAuthor($author);
        }

        return $comment;
    }

    public function findByPost(Post $post): ArrayCollection
    {
        $comments = new ArrayCollection($this->findBy(['post' => $post]));

        foreach ($comments as $comment) {
            $author = $this->userAdapter->getAuthorById($comment->getAuthorId());
            $comment->setAuthor($author);
        }

        return $comments;
    }
}
