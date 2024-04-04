<?php

declare(strict_types=1);

namespace App\Posts\Domain\Entity;

use App\Posts\Domain\Aggregate\Post;
use App\Posts\Domain\ValueObject\Author;
use App\Shared\Domain\Service\UlidService;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'posts_comments')]
class Comment
{
    #[ORM\Id]
    #[ORM\Column(type: 'ulid')]
    private string $id;

    #[ORM\Column(type: 'string')]
    private string $text;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(targetEntity: Post::class, cascade: ['persist'], inversedBy: 'comments')]
    #[ORM\JoinColumn(name: 'post_id', referencedColumnName: 'id')]
    private Post $post;

    private Author $author;

    #[ORM\Column(type: 'ulid')]
    private string $authorId;

    public function __construct(string $text, Author $author, Post $post)
    {
        $this->id = UlidService::generate();
        $this->text = $text;
        $this->author = $author;
        $this->authorId = $author->getId();
        $this->post = $post;
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function setAuthor(Author $author): Comment
    {
        $this->author = $author;
        $this->authorId = $author->getId();

        return $this;
    }
}