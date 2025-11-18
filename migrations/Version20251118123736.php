<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251118123736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE playlist (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, embed_url CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , is_published BOOLEAN NOT NULL)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, title, slug, content, excerpt, image, is_featured, created_at, updated_at, is_published, tag FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content CLOB NOT NULL, excerpt VARCHAR(500) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, is_featured BOOLEAN NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , is_published BOOLEAN NOT NULL, tag VARCHAR(100) DEFAULT NULL)');
        $this->addSql('INSERT INTO article (id, title, slug, content, excerpt, image, is_featured, created_at, updated_at, is_published, tag) SELECT id, title, slug, content, excerpt, image, is_featured, created_at, updated_at, is_published, tag FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66989D9B62 ON article (slug)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__podcast AS SELECT id, embed_url, created_at, is_published FROM podcast');
        $this->addSql('DROP TABLE podcast');
        $this->addSql('CREATE TABLE podcast (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, embed_url CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , is_published BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO podcast (id, embed_url, created_at, is_published) SELECT id, embed_url, created_at, is_published FROM __temp__podcast');
        $this->addSql('DROP TABLE __temp__podcast');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, title, slug, content, excerpt, image, is_featured, created_at, updated_at, is_published, tag FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content CLOB NOT NULL, excerpt VARCHAR(500) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, is_featured BOOLEAN NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, is_published BOOLEAN NOT NULL, tag VARCHAR(100) DEFAULT NULL)');
        $this->addSql('INSERT INTO article (id, title, slug, content, excerpt, image, is_featured, created_at, updated_at, is_published, tag) SELECT id, title, slug, content, excerpt, image, is_featured, created_at, updated_at, is_published, tag FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66989D9B62 ON article (slug)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__podcast AS SELECT id, embed_url, created_at, is_published FROM podcast');
        $this->addSql('DROP TABLE podcast');
        $this->addSql('CREATE TABLE podcast (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, embed_url CLOB NOT NULL, created_at DATETIME NOT NULL, is_published BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO podcast (id, embed_url, created_at, is_published) SELECT id, embed_url, created_at, is_published FROM __temp__podcast');
        $this->addSql('DROP TABLE __temp__podcast');
    }
}
