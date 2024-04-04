<?php

declare(strict_types=1);

namespace App\Tests\Feature\Users\Infrastructure\Api;

use App\Posts\Infrastructure\Adapter\UserDTOInterface;
use App\Users\Domain\Entity\User;
use App\Users\Infrastructure\Api\PostsUserApi;
use App\Users\Infrastructure\Repository\UserRepository;
use App\Users\Application\Factory\UserFakeFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostsUserApiTest extends WebTestCase
{
    private UserRepository $userRepository;
    private UserFakeFactory $userFakeFactory;
    private PostsUserApi $postsUserApi;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->userFakeFactory = $this->createMock(UserFakeFactory::class);
        $this->postsUserApi = new PostsUserApi($this->userRepository, $this->userFakeFactory);
    }

    public function testUserNotFound(): void
    {
        $this->userRepository->expects($this->once())
            ->method('findById')
            ->willReturn(null);

        $this->assertNull($this->postsUserApi->getById('non-existing-id'));
    }

    public function userFoundSuccessfully(): void
    {
        $user = $this->createMock(User::class);
        $this->userRepository->expects($this->once())
            ->method('findById')
            ->willReturn($user);

        $this->assertSame($user, $this->postsUserApi->getById('existing-id'));
    }

    public function fakeUserCreatedSuccessfully(): void
    {
        $fakeUser = $this->createMock(User::class);
        $this->userFakeFactory->expects($this->once())
            ->method('create')
            ->willReturn($fakeUser);

        $this->userRepository->expects($this->once())
            ->method('add')
            ->with($fakeUser);

        $createdUser = $this->postsUserApi->createFake();

        $this->assertSame($fakeUser, $createdUser);
    }
}