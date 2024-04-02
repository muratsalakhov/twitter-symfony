<?php

declare(strict_types=1);

namespace App\Tests\Tools;

use JsonException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @method static KernelBrowser createClient()
 */
trait RequestTrait
{
    protected KernelBrowser $client;

    /**
     * Инициализация клиента для запросов
     * @return void
     */
    public function initClient(): void
    {
        $this->client = static::createClient();
    }

    /**
     * Сформировать json строку
     * @throws JsonException
     */
    protected function makeJsonString(array $data): string
    {
        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    /**
     * Выполнить post запрос
     * @param string $url
     * @param array $data
     * @return Crawler
     * @throws JsonException
     */
    protected function post(string $url, array $data): Crawler
    {
        return $this->client->request(
            method: 'POST',
            uri: $url,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: $this->makeJsonString($data)
        );
    }

    /**
     * Выполнить get запрос
     * @param string $url
     * @param array $data
     * @return Crawler
     * @throws JsonException
     */
    protected function get(string $url, array $data): Crawler
    {
        return $this->client->request(
            method: 'GET',
            uri: $url,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: $this->makeJsonString($data)
        );
    }

    /**
     * Получить содержимое ответа в виде массива
     * @return array
     * @throws JsonException
     */
    protected function getResponseData(): array
    {
        return json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Получить содержимое ответа в виде строки
     * @return string
     */
    protected function getResponseRaw(): string
    {
        return $this->client->getResponse()->getContent();
    }
}