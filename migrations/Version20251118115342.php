<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251118115342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, icon VARCHAR(50) DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C1989D9B62 ON category (slug)');

        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content CLOB NOT NULL, excerpt VARCHAR(500) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, is_featured BOOLEAN NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, is_published BOOLEAN NOT NULL, tag VARCHAR(100) DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66989D9B62 ON article (slug)');

        $this->addSql('CREATE TABLE podcast (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, embed_url CLOB NOT NULL, created_at DATETIME NOT NULL, is_published BOOLEAN NOT NULL)');

        $this->addSql('CREATE TABLE article_category (article_id INTEGER NOT NULL, category_id INTEGER NOT NULL, PRIMARY KEY(article_id, category_id), CONSTRAINT FK_53A4EDAA7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_53A4EDAA12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_53A4EDAA7294869C ON article_category (article_id)');
        $this->addSql('CREATE INDEX IDX_53A4EDAA12469DE2 ON article_category (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE article_category');
        $this->addSql('DROP TABLE podcast');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE category');
    }
}
