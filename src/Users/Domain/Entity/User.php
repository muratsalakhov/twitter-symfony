<?php

declare(strict_types=1);

namespace App\Users\Domain\Entity;

use App\Shared\Domain\Security\AuthUserInterface;
use App\Shared\Domain\Service\UlidService;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: '')]
#[ORM\Table(name: 'users_users')]
class User implements AuthUserInterface
{
    #[ORM\Id()]
    #[ORM\Column(type: 'ulid', unique: true)]
    private string $ulid;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $email;

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $registeredAt;

    public function __construct(string $name, string $email, string $password)
    {
        $this->ulid = UlidService::generate();
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->registeredAt = new DateTimeImmutable();
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRegisteredAt(): DateTimeImmutable
    {
        return $this->registeredAt;
    }
}