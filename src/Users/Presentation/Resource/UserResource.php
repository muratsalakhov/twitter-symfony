<?php

declare(strict_types=1);

namespace App\Users\Presentation\Resource;

use App\Shared\Presentation\Resource\AbstractResource;
use App\Users\Domain\Entity\User;

class UserResource extends AbstractResource
{
    public static function make(?User $user): array
    {
        if (is_null($user)) {
            return [];
        }

        return [
            'ulid' => $user->getUlid(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
        ];
    }
}