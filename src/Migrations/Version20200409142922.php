<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200409142922 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_64C19C15E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE figure (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, display_picture_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_2F57B37A5E237E06 (name), UNIQUE INDEX UNIQ_2F57B37A989D9B62 (slug), INDEX IDX_2F57B37A12469DE2 (category_id), UNIQUE INDEX UNIQ_2F57B37A43FE841E (display_picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, figure_id INT NOT NULL, extension VARCHAR(5) NOT NULL, alt VARCHAR(50) NOT NULL, INDEX IDX_16DB4F895C011B5 (figure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, figure_id INT NOT NULL, video_id VARCHAR(25) NOT NULL, type VARCHAR(8) NOT NULL, INDEX IDX_7CC7DA2C5C011B5 (figure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37A12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37A43FE841E FOREIGN KEY (display_picture_id) REFERENCES picture (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F895C011B5 FOREIGN KEY (figure_id) REFERENCES figure (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C5C011B5 FOREIGN KEY (figure_id) REFERENCES figure (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37A12469DE2');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F895C011B5');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C5C011B5');
        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37A43FE841E');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE figure');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE video');
    }
}
