<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240403215521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создание таблицы Posts';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE posts_posts (id UUID NOT NULL, text VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, author_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE posts_posts ADD CONSTRAINT FK_AUTHOR_ID FOREIGN KEY (author_id) REFERENCES users_users (ulid) ON DELETE CASCADE');
        $this->addSql('COMMENT ON COLUMN posts_posts.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN posts_posts.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN posts_posts.author_id IS \'(DC2Type:ulid)\'');
        $this->addSql('ALTER INDEX uniq_f6415eb1e7927c74 RENAME TO UNIQ_F3F401A0E7927C74');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE posts_posts');
        $this->addSql('ALTER INDEX uniq_f3f401a0e7927c74 RENAME TO uniq_f6415eb1e7927c74');
    }
}
