<?php

declare(strict_types=1);

namespace App\Tests\Feature\Posts\Infrastructure\Repository;

use App\Posts\Infrastructure\Adapter\UserAdapter;
use App\Posts\Infrastructure\Repository\AuthorRepository;
use App\Tests\Tools\DITrait;
use App\Tests\Tools\TransactionTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthorRepositoryTest extends WebTestCase
{
    use DITrait;
    use TransactionTrait;

    private AuthorRepository $authorRepository;

    private UserAdapter $userAdapter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authorRepository = $this->getService(AuthorRepository::class);
        $this->userAdapter = $this->getService(UserAdapter::class);

        $this->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->rollbackTransaction();

        parent::tearDown();
    }

    public function testAuthorFoundSuccessfully(): void
    {
        // prepare
        $author = $this->userAdapter->createFakeAuthor();

        // act
        $foundAuthor = $this->authorRepository->findById($author->getId());

        // assert
        $this->assertEquals($author->getId(), $foundAuthor->getId());
    }
}
