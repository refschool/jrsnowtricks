<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200429155825 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(100) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C15E237E06 ON category (name)');
        $this->addSql('CREATE TABLE figure (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, name VARCHAR(100) NOT NULL, description CLOB NOT NULL, slug VARCHAR(100) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2F57B37A5E237E06 ON figure (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2F57B37A989D9B62 ON figure (slug)');
        $this->addSql('CREATE INDEX IDX_2F57B37A12469DE2 ON figure (category_id)');
        $this->addSql('CREATE TABLE picture (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, figure_id INTEGER NOT NULL, extension VARCHAR(5) NOT NULL, alt VARCHAR(50) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_16DB4F895C011B5 ON picture (figure_id)');
        $this->addSql('CREATE TABLE video (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, figure_id INTEGER NOT NULL, video_id VARCHAR(25) NOT NULL, platform VARCHAR(8) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2C5C011B5 ON video (figure_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE figure');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE video');
    }
}
