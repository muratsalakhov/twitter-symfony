<?php

declare(strict_types=1);

namespace App\Posts\Infrastructure\Adapter;

interface UserDTOInterface
{
    public function getId(): string;

    public function getName(): string;
}
