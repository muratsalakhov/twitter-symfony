<?php

namespace Feature\Api;

use JsonException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class HealthCheckTest extends WebTestCase
{
    /**
     * @throws JsonException
     */
    public function test_request_successful(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/healthcheck');

        self::assertResponseIsSuccessful();

        $jsonResult = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertEquals('ok', $jsonResult['status']);
    }
}