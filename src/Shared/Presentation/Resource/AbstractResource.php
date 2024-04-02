<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Resource;

abstract class AbstractResource
{
    public static function collection(array $collection): array
    {
        $result = [];

        foreach ($collection as $item) {
            $result[] = static::make($item);
        }

        return $result;
    }
}
