<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210706185912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__rdv AS SELECT id, patient, symptomes, place, date, result FROM rdv');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('CREATE TABLE rdv (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, patient VARCHAR(255) NOT NULL COLLATE BINARY, symptomes VARCHAR(255) NOT NULL COLLATE BINARY, place VARCHAR(255) NOT NULL COLLATE BINARY, date DATETIME NOT NULL, result VARCHAR(255) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO rdv (id, patient, symptomes, place, date, result) SELECT id, patient, symptomes, place, date, result FROM __temp__rdv');
        $this->addSql('DROP TABLE __temp__rdv');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv ADD COLUMN tester VARCHAR(255) NOT NULL COLLATE BINARY');
    }
}
