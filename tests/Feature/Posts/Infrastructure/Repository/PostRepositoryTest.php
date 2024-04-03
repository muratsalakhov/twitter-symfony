<?php

declare(strict_types=1);

namespace App\Tests\Feature\Posts\Infrastructure\Repository;

use App\Posts\Application\Factory\PostFakeFactory;
use App\Posts\Domain\Aggregate\Post;
use App\Posts\Domain\ValueObject\Author;
use App\Posts\Infrastructure\Adapter\UserAdapter;
use App\Posts\Infrastructure\Repository\PostRepository;
use App\Tests\Tools\DITrait;
use App\Tests\Tools\TransactionTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostRepositoryTest extends WebTestCase
{
    use DITrait;
    use TransactionTrait;

    private PostRepository $postRepository;

    private PostFakeFactory $postFakeFactory;

    private UserAdapter $userAdapter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->postRepository = $this->getService(PostRepository::class);
        $this->postFakeFactory = $this->getService(PostFakeFactory::class);
        $this->userAdapter = $this->getService(UserAdapter::class);

        $this->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->rollbackTransaction();

        parent::tearDown();
    }

    public function testPostAddedSuccessfully(): void
    {
        // prepare
        $user = $this->userAdapter->createFakeAuthor();
        $author = new Author($user->getId(), $user->getName());
        $post = $this->postFakeFactory->create(author: $author);

        // act
        $this->postRepository->add($post);
        $createdPost = $this->postRepository->findById($post->getId());

        // assert
        $this->assertEquals($post->getId(), $createdPost->getId());
    }

    public function testPostFoundByAuthorSuccessfully(): void
    {
        // prepare
        $user = $this->userAdapter->createFakeAuthor();
        $author = new Author($user->getId(), $user->getName());
        $post = $this->postFakeFactory->create(author: $author);

        // act
        $this->postRepository->add($post);
        $createdPosts = $this->postRepository->findAllByAuthor($post->getAuthorId());

        $postIds = [$post->getId()];
        $createdPostsIds = array_map(static fn(Post $post) => $post->getId(), $createdPosts);

        // assert
        $this->assertEquals($postIds, $createdPostsIds);
    }
}
