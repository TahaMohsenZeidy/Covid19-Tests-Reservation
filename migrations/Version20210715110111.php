<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210715110111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_61B890856B899279');
        $this->addSql('CREATE TEMPORARY TABLE __temp__medical_history AS SELECT id, patient_id, disease, medecine_1, medecine_2, medecine_3, scan, scan_1, analyse, analyse_1 FROM medical_history');
        $this->addSql('DROP TABLE medical_history');
        $this->addSql('CREATE TABLE medical_history (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, patient_id INTEGER NOT NULL, disease VARCHAR(255) DEFAULT NULL COLLATE BINARY, medecine_1 VARCHAR(255) DEFAULT NULL COLLATE BINARY, medecine_2 VARCHAR(255) DEFAULT NULL COLLATE BINARY, medecine_3 VARCHAR(255) DEFAULT NULL COLLATE BINARY, scan VARCHAR(255) DEFAULT NULL COLLATE BINARY, scan_1 VARCHAR(255) DEFAULT NULL COLLATE BINARY, analyse VARCHAR(255) DEFAULT NULL COLLATE BINARY, analyse_1 VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_61B890856B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO medical_history (id, patient_id, disease, medecine_1, medecine_2, medecine_3, scan, scan_1, analyse, analyse_1) SELECT id, patient_id, disease, medecine_1, medecine_2, medecine_3, scan, scan_1, analyse, analyse_1 FROM __temp__medical_history');
        $this->addSql('DROP TABLE __temp__medical_history');
        $this->addSql('CREATE INDEX IDX_61B890856B899279 ON medical_history (patient_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__place AS SELECT id, room, floor, kit, country, result FROM place');
        $this->addSql('DROP TABLE place');
        $this->addSql('CREATE TABLE place (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tester_id INTEGER DEFAULT NULL, room VARCHAR(255) NOT NULL COLLATE BINARY, floor VARCHAR(255) NOT NULL COLLATE BINARY, kit INTEGER NOT NULL, country VARCHAR(255) NOT NULL COLLATE BINARY, result VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_741D53CD979A21C1 FOREIGN KEY (tester_id) REFERENCES tester (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO place (id, room, floor, kit, country, result) SELECT id, room, floor, kit, country, result FROM __temp__place');
        $this->addSql('DROP TABLE __temp__place');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_741D53CD979A21C1 ON place (tester_id)');
        $this->addSql('DROP INDEX UNIQ_10C31F86DA6A219');
        $this->addSql('DROP INDEX UNIQ_10C31F86ECAB15B3');
        $this->addSql('DROP INDEX UNIQ_10C31F862902E187');
        $this->addSql('DROP INDEX IDX_10C31F866B899279');
        $this->addSql('CREATE TEMPORARY TABLE __temp__rdv AS SELECT id, symptomes_id, travel_id, place_id, patient_id, date, result FROM rdv');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('CREATE TABLE rdv (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, symptomes_id INTEGER NOT NULL, travel_id INTEGER DEFAULT NULL, place_id INTEGER DEFAULT NULL, patient_id INTEGER DEFAULT NULL, date DATETIME NOT NULL, result VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_10C31F866B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_10C31F862902E187 FOREIGN KEY (symptomes_id) REFERENCES symptomes (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_10C31F86ECAB15B3 FOREIGN KEY (travel_id) REFERENCES travel (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_10C31F86DA6A219 FOREIGN KEY (place_id) REFERENCES place (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO rdv (id, symptomes_id, travel_id, place_id, patient_id, date, result) SELECT id, symptomes_id, travel_id, place_id, patient_id, date, result FROM __temp__rdv');
        $this->addSql('DROP TABLE __temp__rdv');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_10C31F86DA6A219 ON rdv (place_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_10C31F86ECAB15B3 ON rdv (travel_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_10C31F862902E187 ON rdv (symptomes_id)');
        $this->addSql('CREATE INDEX IDX_10C31F866B899279 ON rdv (patient_id)');
        $this->addSql('DROP INDEX IDX_FC505645DA6A219');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tester AS SELECT id, place_id, firstname, lastname, identifier, position, department FROM tester');
        $this->addSql('DROP TABLE tester');
        $this->addSql('CREATE TABLE tester (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, place_id INTEGER DEFAULT NULL, firstname VARCHAR(255) NOT NULL COLLATE BINARY, lastname VARCHAR(255) NOT NULL COLLATE BINARY, identifier VARCHAR(255) NOT NULL COLLATE BINARY, position VARCHAR(255) NOT NULL COLLATE BINARY, department VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_FC505645DA6A219 FOREIGN KEY (place_id) REFERENCES place (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tester (id, place_id, firstname, lastname, identifier, position, department) SELECT id, place_id, firstname, lastname, identifier, position, department FROM __temp__tester');
        $this->addSql('DROP TABLE __temp__tester');
        $this->addSql('CREATE INDEX IDX_FC505645DA6A219 ON tester (place_id)');
        $this->addSql('DROP INDEX IDX_1DD7EE8CDA6A219');
        $this->addSql('CREATE TEMPORARY TABLE __temp__times AS SELECT id, place_id, time, date FROM times');
        $this->addSql('DROP TABLE times');
        $this->addSql('CREATE TABLE times (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, place_id INTEGER DEFAULT NULL, time DATETIME NOT NULL, date DATE NOT NULL, CONSTRAINT FK_1DD7EE8CDA6A219 FOREIGN KEY (place_id) REFERENCES place (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO times (id, place_id, time, date) SELECT id, place_id, time, date FROM __temp__times');
        $this->addSql('DROP TABLE __temp__times');
        $this->addSql('CREATE INDEX IDX_1DD7EE8CDA6A219 ON times (place_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_61B890856B899279');
        $this->addSql('CREATE TEMPORARY TABLE __temp__medical_history AS SELECT id, patient_id, disease, medecine_1, medecine_2, medecine_3, scan, scan_1, analyse, analyse_1 FROM medical_history');
        $this->addSql('DROP TABLE medical_history');
        $this->addSql('CREATE TABLE medical_history (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, patient_id INTEGER NOT NULL, disease VARCHAR(255) DEFAULT NULL, medecine_1 VARCHAR(255) DEFAULT NULL, medecine_2 VARCHAR(255) DEFAULT NULL, medecine_3 VARCHAR(255) DEFAULT NULL, scan VARCHAR(255) DEFAULT NULL, scan_1 VARCHAR(255) DEFAULT NULL, analyse VARCHAR(255) DEFAULT NULL, analyse_1 VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO medical_history (id, patient_id, disease, medecine_1, medecine_2, medecine_3, scan, scan_1, analyse, analyse_1) SELECT id, patient_id, disease, medecine_1, medecine_2, medecine_3, scan, scan_1, analyse, analyse_1 FROM __temp__medical_history');
        $this->addSql('DROP TABLE __temp__medical_history');
        $this->addSql('CREATE INDEX IDX_61B890856B899279 ON medical_history (patient_id)');
        $this->addSql('DROP INDEX UNIQ_741D53CD979A21C1');
        $this->addSql('CREATE TEMPORARY TABLE __temp__place AS SELECT id, room, floor, kit, country, result FROM place');
        $this->addSql('DROP TABLE place');
        $this->addSql('CREATE TABLE place (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room VARCHAR(255) NOT NULL, floor VARCHAR(255) NOT NULL, kit INTEGER NOT NULL, country VARCHAR(255) NOT NULL, result VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO place (id, room, floor, kit, country, result) SELECT id, room, floor, kit, country, result FROM __temp__place');
        $this->addSql('DROP TABLE __temp__place');
        $this->addSql('DROP INDEX IDX_10C31F866B899279');
        $this->addSql('DROP INDEX UNIQ_10C31F862902E187');
        $this->addSql('DROP INDEX UNIQ_10C31F86ECAB15B3');
        $this->addSql('DROP INDEX UNIQ_10C31F86DA6A219');
        $this->addSql('CREATE TEMPORARY TABLE __temp__rdv AS SELECT id, patient_id, symptomes_id, travel_id, place_id, date, result FROM rdv');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('CREATE TABLE rdv (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, patient_id INTEGER DEFAULT NULL, symptomes_id INTEGER NOT NULL, travel_id INTEGER DEFAULT NULL, place_id INTEGER DEFAULT NULL, date DATETIME NOT NULL, result VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO rdv (id, patient_id, symptomes_id, travel_id, place_id, date, result) SELECT id, patient_id, symptomes_id, travel_id, place_id, date, result FROM __temp__rdv');
        $this->addSql('DROP TABLE __temp__rdv');
        $this->addSql('CREATE INDEX IDX_10C31F866B899279 ON rdv (patient_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_10C31F862902E187 ON rdv (symptomes_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_10C31F86ECAB15B3 ON rdv (travel_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_10C31F86DA6A219 ON rdv (place_id)');
        $this->addSql('DROP INDEX IDX_FC505645DA6A219');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tester AS SELECT id, place_id, firstname, lastname, identifier, position, department FROM tester');
        $this->addSql('DROP TABLE tester');
        $this->addSql('CREATE TABLE tester (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, place_id INTEGER DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, identifier VARCHAR(255) NOT NULL, position VARCHAR(255) NOT NULL, department VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO tester (id, place_id, firstname, lastname, identifier, position, department) SELECT id, place_id, firstname, lastname, identifier, position, department FROM __temp__tester');
        $this->addSql('DROP TABLE __temp__tester');
        $this->addSql('CREATE INDEX IDX_FC505645DA6A219 ON tester (place_id)');
        $this->addSql('DROP INDEX IDX_1DD7EE8CDA6A219');
        $this->addSql('CREATE TEMPORARY TABLE __temp__times AS SELECT id, place_id, time, date FROM times');
        $this->addSql('DROP TABLE times');
        $this->addSql('CREATE TABLE times (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, place_id INTEGER DEFAULT NULL, time DATETIME NOT NULL, date DATE NOT NULL)');
        $this->addSql('INSERT INTO times (id, place_id, time, date) SELECT id, place_id, time, date FROM __temp__times');
        $this->addSql('DROP TABLE __temp__times');
        $this->addSql('CREATE INDEX IDX_1DD7EE8CDA6A219 ON times (place_id)');
    }
}
