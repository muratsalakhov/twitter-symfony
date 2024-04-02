<?php

declare(strict_types=1);

namespace App\Tests\Feature\Users\Presentation\Controller;

use App\Tests\Tools\FakerTrait;
use App\Tests\Tools\RequestTrait;
use App\Tests\Tools\TransactionTrait;
use App\Users\Application\Factory\UserFakeFactory;
use App\Users\Infrastructure\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AuthControllerTest extends WebTestCase
{
    use TransactionTrait;
    use FakerTrait;
    use RequestTrait;

    protected function setUp(): void
    {
        parent::setUp();

        $this->initClient();

        $this->userFakeFactory = $this->getService(UserFakeFactory::class);
        $this->userRepository = $this->getService(UserRepository::class);

        $this->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->rollbackTransaction();

        parent::tearDown();
    }

    public function testRegister(): void
    {
        $name = $this->getFaker()->name();
        $email = $this->getFaker()->email();
        $password = $this->getFaker()->password();

        $this->post('/api/auth/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $data = $this->getResponseData()['data'];

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertJson($this->getResponseRaw());
        $this->assertArrayHasKey('ulid', $data);
        $this->assertEquals($name, $data['name']);
        $this->assertEquals($email, $data['email']);
    }

    public function testLogin(): void
    {
        $testPassword = $this->getFaker()->password();

        $user = $this->userFakeFactory->create(password: $testPassword);
        $this->userRepository->add($user);

        $this->post('/api/auth/login', [
            'email' => $user->getEmail(),
            'password' => $testPassword,
        ]);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertJson($this->getResponseRaw());
        $data = $this->getResponseData()['data'];

        $this->assertArrayHasKey('token', $data);
        $this->assertIsString($data['token']);
    }

    public function testFailedLogin(): void
    {
        $user = $this->userFakeFactory->create();
        $this->userRepository->add($user);

        $this->post('/api/auth/login', [
            'email' => $user->getEmail(),
            'password' => $this->getFaker()->password(),
        ]);

        self::assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }
}
