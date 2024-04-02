<?php

declare(strict_types=1);

namespace App\Tests\Feature\Users\Infrastructure\Repository;

use App\Tests\Tools\DITrait;
use App\Tests\Tools\TransactionTrait;
use App\Users\Application\Factory\UserFakeFactory;
use App\Users\Infrastructure\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRepositoryTest extends WebTestCase
{
    use DITrait;
    use TransactionTrait;

    private UserRepository $userRepository;

    private UserFakeFactory $userFakeFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->getService(UserRepository::class);
        $this->userFakeFactory = $this->getService(UserFakeFactory::class);

        $this->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->rollbackTransaction();

        parent::tearDown();
    }

    public function testUserAddedSuccessfully(): void
    {
        // prepare
        $user = $this->userFakeFactory->create();

        // act
        $this->userRepository->add($user);
        $createdUser = $this->userRepository->findById($user->getUlid());

        // assert
        $this->assertEquals($user->getUlid(), $createdUser->getUlid());
    }

    public function testUserFoundByEmailSuccessfully(): void
    {
        // prepare
        $user = $this->userFakeFactory->create();

        // act
        $this->userRepository->add($user);
        $createdUser = $this->userRepository->findByEmail($user->getEmail());

        // assert
        $this->assertEquals($user->getUlid(), $createdUser->getUlid());
    }
}
