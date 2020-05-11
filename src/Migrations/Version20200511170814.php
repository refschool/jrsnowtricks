<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200511170814 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_2F57B37A12469DE2');
        $this->addSql('DROP INDEX UNIQ_2F57B37A989D9B62');
        $this->addSql('DROP INDEX UNIQ_2F57B37A5E237E06');
        $this->addSql('CREATE TEMPORARY TABLE __temp__figure AS SELECT id, category_id, name, description, slug FROM figure');
        $this->addSql('DROP TABLE figure');
        $this->addSql('CREATE TABLE figure (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, name VARCHAR(100) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, slug VARCHAR(100) NOT NULL COLLATE BINARY, created_at DATETIME DEFAULT NULL, last_modified DATETIME DEFAULT NULL, CONSTRAINT FK_2F57B37A12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO figure (id, category_id, name, description, slug) SELECT id, category_id, name, description, slug FROM __temp__figure');
        $this->addSql('DROP TABLE __temp__figure');
        $this->addSql('CREATE INDEX IDX_2F57B37A12469DE2 ON figure (category_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2F57B37A989D9B62 ON figure (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2F57B37A5E237E06 ON figure (name)');
        $this->addSql('DROP INDEX IDX_16DB4F895C011B5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__picture AS SELECT id, figure_id, extension, alt FROM picture');
        $this->addSql('DROP TABLE picture');
        $this->addSql('CREATE TABLE picture (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, figure_id INTEGER NOT NULL, extension VARCHAR(5) NOT NULL COLLATE BINARY, alt VARCHAR(50) NOT NULL COLLATE BINARY, CONSTRAINT FK_16DB4F895C011B5 FOREIGN KEY (figure_id) REFERENCES figure (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO picture (id, figure_id, extension, alt) SELECT id, figure_id, extension, alt FROM __temp__picture');
        $this->addSql('DROP TABLE __temp__picture');
        $this->addSql('CREATE INDEX IDX_16DB4F895C011B5 ON picture (figure_id)');
        $this->addSql('DROP INDEX IDX_7CC7DA2C5C011B5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__video AS SELECT id, figure_id, video_id, platform FROM video');
        $this->addSql('DROP TABLE video');
        $this->addSql('CREATE TABLE video (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, figure_id INTEGER NOT NULL, video_id VARCHAR(25) NOT NULL COLLATE BINARY, platform VARCHAR(8) NOT NULL COLLATE BINARY, CONSTRAINT FK_7CC7DA2C5C011B5 FOREIGN KEY (figure_id) REFERENCES figure (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO video (id, figure_id, video_id, platform) SELECT id, figure_id, video_id, platform FROM __temp__video');
        $this->addSql('DROP TABLE __temp__video');
        $this->addSql('CREATE INDEX IDX_7CC7DA2C5C011B5 ON video (figure_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_2F57B37A5E237E06');
        $this->addSql('DROP INDEX UNIQ_2F57B37A989D9B62');
        $this->addSql('DROP INDEX IDX_2F57B37A12469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__figure AS SELECT id, category_id, name, description, slug FROM figure');
        $this->addSql('DROP TABLE figure');
        $this->addSql('CREATE TABLE figure (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, name VARCHAR(100) NOT NULL, description CLOB NOT NULL, slug VARCHAR(100) NOT NULL)');
        $this->addSql('INSERT INTO figure (id, category_id, name, description, slug) SELECT id, category_id, name, description, slug FROM __temp__figure');
        $this->addSql('DROP TABLE __temp__figure');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2F57B37A5E237E06 ON figure (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2F57B37A989D9B62 ON figure (slug)');
        $this->addSql('CREATE INDEX IDX_2F57B37A12469DE2 ON figure (category_id)');
        $this->addSql('DROP INDEX IDX_16DB4F895C011B5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__picture AS SELECT id, figure_id, extension, alt FROM picture');
        $this->addSql('DROP TABLE picture');
        $this->addSql('CREATE TABLE picture (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, figure_id INTEGER NOT NULL, extension VARCHAR(5) NOT NULL, alt VARCHAR(50) NOT NULL)');
        $this->addSql('INSERT INTO picture (id, figure_id, extension, alt) SELECT id, figure_id, extension, alt FROM __temp__picture');
        $this->addSql('DROP TABLE __temp__picture');
        $this->addSql('CREATE INDEX IDX_16DB4F895C011B5 ON picture (figure_id)');
        $this->addSql('DROP INDEX IDX_7CC7DA2C5C011B5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__video AS SELECT id, figure_id, video_id, platform FROM video');
        $this->addSql('DROP TABLE video');
        $this->addSql('CREATE TABLE video (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, figure_id INTEGER NOT NULL, video_id VARCHAR(25) NOT NULL, platform VARCHAR(8) NOT NULL)');
        $this->addSql('INSERT INTO video (id, figure_id, video_id, platform) SELECT id, figure_id, video_id, platform FROM __temp__video');
        $this->addSql('DROP TABLE __temp__video');
        $this->addSql('CREATE INDEX IDX_7CC7DA2C5C011B5 ON video (figure_id)');
    }
}
