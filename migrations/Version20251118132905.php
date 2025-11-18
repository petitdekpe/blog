<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251118132905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, title, slug, content, excerpt, image, is_featured, created_at, updated_at, is_published, tag FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content CLOB NOT NULL, excerpt VARCHAR(500) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, is_featured BOOLEAN NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , is_published BOOLEAN NOT NULL, tag VARCHAR(100) DEFAULT NULL, CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article (id, title, slug, content, excerpt, image, is_featured, created_at, updated_at, is_published, tag) SELECT id, title, slug, content, excerpt, image, is_featured, created_at, updated_at, is_published, tag FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66989D9B62 ON article (slug)');
        $this->addSql('CREATE INDEX IDX_23A0E66F675F31B ON article (author_id)');
        $this->addSql('ALTER TABLE user ADD COLUMN twitter_handle VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN twitter_profile_image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, title, slug, content, excerpt, image, is_featured, created_at, updated_at, is_published, tag FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content CLOB NOT NULL, excerpt VARCHAR(500) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, is_featured BOOLEAN NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , is_published BOOLEAN NOT NULL, tag VARCHAR(100) DEFAULT NULL)');
        $this->addSql('INSERT INTO article (id, title, slug, content, excerpt, image, is_featured, created_at, updated_at, is_published, tag) SELECT id, title, slug, content, excerpt, image, is_featured, created_at, updated_at, is_published, tag FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66989D9B62 ON article (slug)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, password, first_name, last_name, phone FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, phone VARCHAR(20) DEFAULT NULL)');
        $this->addSql('INSERT INTO user (id, email, roles, password, first_name, last_name, phone) SELECT id, email, roles, password, first_name, last_name, phone FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }
}
