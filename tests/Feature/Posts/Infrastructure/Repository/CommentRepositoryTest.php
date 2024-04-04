<?php

declare(strict_types=1);

namespace App\Tests\Feature\Posts\Infrastructure\Repository;

use App\Posts\Application\Factory\CommentFakeFactory;
use App\Posts\Application\Factory\PostFakeFactory;
use App\Posts\Domain\Aggregate\Post;
use App\Posts\Domain\ValueObject\Author;
use App\Posts\Infrastructure\Adapter\UserAdapter;
use App\Posts\Infrastructure\Repository\CommentRepository;
use App\Tests\Tools\DITrait;
use App\Tests\Tools\TransactionTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentRepositoryTest extends WebTestCase
{
    use DITrait;
    use TransactionTrait;

    private CommentRepository $commentRepository;

    private CommentFakeFactory $commentFakeFactory;

    private PostFakeFactory $postFakeFactory;

    private UserAdapter $userAdapter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commentRepository = $this->getService(CommentRepository::class);
        $this->commentFakeFactory = $this->getService(CommentFakeFactory::class);
        $this->postFakeFactory = $this->getService(PostFakeFactory::class);
        $this->userAdapter = $this->getService(UserAdapter::class);

        //$this->beginTransaction();
    }

    protected function tearDown(): void
    {
        //$this->rollbackTransaction();

        parent::tearDown();
    }

    public function testCommentAddedSuccessfully(): void
    {
        // prepare
        $author = $this->userAdapter->createFakeAuthor();
        $post = $this->postFakeFactory->create(author: $author);
        $comment = $this->commentFakeFactory->create(author: $author, post: $post);

        // act
        $this->commentRepository->add($comment);
        $createdComment = $this->commentRepository->findById($comment->getId());

        // assert
        $this->assertEquals($comment->getId(), $createdComment->getId());
    }

    public function testCommentFoundByPostSuccessfully(): void
    {
        // prepare
        $author = $this->userAdapter->createFakeAuthor();
        $post = $this->postFakeFactory->create(author: $author);
        $comment = $this->commentFakeFactory->create(author: $author, post: $post);

        // act
        $this->commentRepository->add($comment);
        $createdComments = $this->commentRepository->findByPost($post);

        // assert
        $this->assertNotEmpty($createdComments);
        $this->assertEquals($comment->getId(), $createdComments[0]->getId());
    }
}
