<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231127102223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lieu (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(60) NOT NULL, ville VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employe ADD lieu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B96AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id)');
        $this->addSql('CREATE INDEX IDX_F804D3B96AB213CC ON employe (lieu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY FK_F804D3B96AB213CC');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('DROP INDEX IDX_F804D3B96AB213CC ON employe');
        $this->addSql('ALTER TABLE employe DROP lieu_id');
    }
}
