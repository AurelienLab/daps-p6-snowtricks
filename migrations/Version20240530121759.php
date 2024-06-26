<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240530121759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trick_media (id INT AUTO_INCREMENT NOT NULL, trick_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', media_type VARCHAR(255) NOT NULL, INDEX IDX_A103A1B3B281BE2E (trick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick_media_embed (id INT NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick_media_image (id INT NOT NULL, image VARCHAR(255) NOT NULL, alt VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trick_media ADD CONSTRAINT FK_A103A1B3B281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('ALTER TABLE trick_media_embed ADD CONSTRAINT FK_D694A6CBBF396750 FOREIGN KEY (id) REFERENCES trick_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trick_media_image ADD CONSTRAINT FK_5413A787BF396750 FOREIGN KEY (id) REFERENCES trick_media (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trick_media DROP FOREIGN KEY FK_A103A1B3B281BE2E');
        $this->addSql('ALTER TABLE trick_media_embed DROP FOREIGN KEY FK_D694A6CBBF396750');
        $this->addSql('ALTER TABLE trick_media_image DROP FOREIGN KEY FK_5413A787BF396750');
        $this->addSql('DROP TABLE trick_media');
        $this->addSql('DROP TABLE trick_media_embed');
        $this->addSql('DROP TABLE trick_media_image');
    }
}
