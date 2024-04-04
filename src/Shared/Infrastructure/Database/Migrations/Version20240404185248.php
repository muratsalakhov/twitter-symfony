<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240404185248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE posts_comments (id UUID NOT NULL, post_id UUID DEFAULT NULL, text VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, author_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_85514EE34B89032C ON posts_comments (post_id)');
        $this->addSql('COMMENT ON COLUMN posts_comments.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN posts_comments.post_id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN posts_comments.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN posts_comments.author_id IS \'(DC2Type:ulid)\'');
        $this->addSql('ALTER TABLE posts_comments ADD CONSTRAINT FK_POST_ID FOREIGN KEY (post_id) REFERENCES posts_posts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posts_comments ADD CONSTRAINT FK_AUTHOR_ID FOREIGN KEY (author_id) REFERENCES users_users (ulid) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE posts_comments DROP CONSTRAINT FK_POST_ID');
        $this->addSql('ALTER TABLE posts_comments DROP CONSTRAINT FK_AUTHOR_ID');
        $this->addSql('DROP TABLE posts_comments');
        $this->addSql('CREATE INDEX IDX_3A5AE1EBF675F31B ON posts_posts (author_id)');
    }
}
