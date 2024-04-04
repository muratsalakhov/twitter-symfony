<?php

declare(strict_types=1);

namespace App\Posts\Domain\Aggregate;

use App\Posts\Domain\ValueObject\Author;
use App\Shared\Domain\Service\UlidService;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'posts_posts')]
class Post
{
    #[ORM\Id]
    #[ORM\Column(type: 'ulid')]
    private string $id;

    #[ORM\Column(type: 'string')]
    private string $text;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'ulid')]
    private string $authorId;

    private Author $author; // todo

    // private array $likes; todo

    // private array $comments; todo

    public function __construct(string $text, Author $author)
    {
        $this->id = UlidService::generate();
        $this->text = $text;
        $this->authorId = $author->getId();
        $this->author = $author;
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

    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function setAuthor(Author $author): Post
    {
        $this->author = $author;
        $this->authorId = $author->getId();

        return $this;
    }
}
