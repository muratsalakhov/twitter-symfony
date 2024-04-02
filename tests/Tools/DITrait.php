<?php

declare(strict_types=1);

namespace App\Tests\Tools;

/**
 * Трейт для получения сервисов через DI контейнер
 */
trait DITrait
{
    /**
     * Получить сервис через DI контейнер
     * @template T
     *
     * @param class-string<T> $service
     *
     * @return T|object|null
     */
    public function getService(string $service)
    {
        return static::getContainer()->get($service);
    }
}