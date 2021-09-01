<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210830202840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_61B890856B899279');
        $this->addSql('CREATE TEMPORARY TABLE __temp__medical_history AS SELECT id, patient_id, disease, medecine1, medecine2, medecine3 FROM medical_history');
        $this->addSql('DROP TABLE medical_history');
        $this->addSql('CREATE TABLE medical_history (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, patient_id INTEGER NOT NULL, disease VARCHAR(255) DEFAULT NULL COLLATE BINARY, medecine1 VARCHAR(255) DEFAULT NULL COLLATE BINARY, medecine2 VARCHAR(255) DEFAULT NULL COLLATE BINARY, medecine3 VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_61B890856B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO medical_history (id, patient_id, disease, medecine1, medecine2, medecine3) SELECT id, patient_id, disease, medecine1, medecine2, medecine3 FROM __temp__medical_history');
        $this->addSql('DROP TABLE __temp__medical_history');
        $this->addSql('CREATE INDEX IDX_61B890856B899279 ON medical_history (patient_id)');
        $this->addSql('DROP INDEX IDX_41AD8DDA3544AD9E');
        $this->addSql('DROP INDEX IDX_41AD8DDA3DA5256D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__medical_history_image AS SELECT medical_history_id, image_id FROM medical_history_image');
        $this->addSql('DROP TABLE medical_history_image');
        $this->addSql('CREATE TABLE medical_history_image (medical_history_id INTEGER NOT NULL, image_id INTEGER NOT NULL, PRIMARY KEY(medical_history_id, image_id), CONSTRAINT FK_41AD8DDA3544AD9E FOREIGN KEY (medical_history_id) REFERENCES medical_history (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_41AD8DDA3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO medical_history_image (medical_history_id, image_id) SELECT medical_history_id, image_id FROM __temp__medical_history_image');
        $this->addSql('DROP TABLE __temp__medical_history_image');
        $this->addSql('CREATE INDEX IDX_41AD8DDA3544AD9E ON medical_history_image (medical_history_id)');
        $this->addSql('CREATE INDEX IDX_41AD8DDA3DA5256D ON medical_history_image (image_id)');
        $this->addSql('DROP INDEX IDX_10C31F86DA6A219');
        $this->addSql('DROP INDEX IDX_10C31F866B899279');
        $this->addSql('DROP INDEX IDX_10C31F862902E187');
        $this->addSql('DROP INDEX IDX_10C31F86ECAB15B3');
        $this->addSql('CREATE TEMPORARY TABLE __temp__rdv AS SELECT id, symptomes_id, travel_id, patient_id, place_id, date, result FROM rdv');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('CREATE TABLE rdv (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, symptomes_id INTEGER NOT NULL, travel_id INTEGER DEFAULT NULL, patient_id INTEGER NOT NULL, place_id INTEGER NOT NULL, date DATETIME NOT NULL, result VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_10C31F866B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_10C31F862902E187 FOREIGN KEY (symptomes_id) REFERENCES symptomes (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_10C31F86ECAB15B3 FOREIGN KEY (travel_id) REFERENCES travel (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_10C31F86DA6A219 FOREIGN KEY (place_id) REFERENCES place (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO rdv (id, symptomes_id, travel_id, patient_id, place_id, date, result) SELECT id, symptomes_id, travel_id, patient_id, place_id, date, result FROM __temp__rdv');
        $this->addSql('DROP TABLE __temp__rdv');
        $this->addSql('CREATE INDEX IDX_10C31F86DA6A219 ON rdv (place_id)');
        $this->addSql('CREATE INDEX IDX_10C31F866B899279 ON rdv (patient_id)');
        $this->addSql('CREATE INDEX IDX_10C31F862902E187 ON rdv (symptomes_id)');
        $this->addSql('CREATE INDEX IDX_10C31F86ECAB15B3 ON rdv (travel_id)');
        $this->addSql('DROP INDEX IDX_FC505645DA6A219');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tester AS SELECT id, place_id, firstname, lastname, identifier, position, elecmail FROM tester');
        $this->addSql('DROP TABLE tester');
        $this->addSql('CREATE TABLE tester (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, place_id INTEGER DEFAULT NULL, firstname VARCHAR(255) NOT NULL COLLATE BINARY, lastname VARCHAR(255) NOT NULL COLLATE BINARY, identifier VARCHAR(255) NOT NULL COLLATE BINARY, position VARCHAR(255) NOT NULL COLLATE BINARY, elecmail VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_FC505645DA6A219 FOREIGN KEY (place_id) REFERENCES place (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tester (id, place_id, firstname, lastname, identifier, position, elecmail) SELECT id, place_id, firstname, lastname, identifier, position, elecmail FROM __temp__tester');
        $this->addSql('DROP TABLE __temp__tester');
        $this->addSql('CREATE INDEX IDX_FC505645DA6A219 ON tester (place_id)');
        $this->addSql('DROP INDEX IDX_1DD7EE8CDA6A219');
        $this->addSql('CREATE TEMPORARY TABLE __temp__times AS SELECT id, place_id, time_begin, time_finish FROM times');
        $this->addSql('DROP TABLE times');
        $this->addSql('CREATE TABLE times (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, place_id INTEGER NOT NULL, time_begin DATETIME NOT NULL, time_finish DATETIME NOT NULL, CONSTRAINT FK_1DD7EE8CDA6A219 FOREIGN KEY (place_id) REFERENCES place (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO times (id, place_id, time_begin, time_finish) SELECT id, place_id, time_begin, time_finish FROM __temp__times');
        $this->addSql('DROP TABLE __temp__times');
        $this->addSql('CREATE INDEX IDX_1DD7EE8CDA6A219 ON times (place_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__travel AS SELECT id, fly_date, destination FROM travel');
        $this->addSql('DROP TABLE travel');
        $this->addSql('CREATE TABLE travel (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, destination VARCHAR(255) NOT NULL COLLATE BINARY, flydate DATETIME NOT NULL)');
        $this->addSql('INSERT INTO travel (id, flydate, destination) SELECT id, fly_date, destination FROM __temp__travel');
        $this->addSql('DROP TABLE __temp__travel');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_61B890856B899279');
        $this->addSql('CREATE TEMPORARY TABLE __temp__medical_history AS SELECT id, patient_id, disease, medecine1, medecine2, medecine3 FROM medical_history');
        $this->addSql('DROP TABLE medical_history');
        $this->addSql('CREATE TABLE medical_history (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, patient_id INTEGER NOT NULL, disease VARCHAR(255) DEFAULT NULL, medecine1 VARCHAR(255) DEFAULT NULL, medecine2 VARCHAR(255) DEFAULT NULL, medecine3 VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO medical_history (id, patient_id, disease, medecine1, medecine2, medecine3) SELECT id, patient_id, disease, medecine1, medecine2, medecine3 FROM __temp__medical_history');
        $this->addSql('DROP TABLE __temp__medical_history');
        $this->addSql('CREATE INDEX IDX_61B890856B899279 ON medical_history (patient_id)');
        $this->addSql('DROP INDEX IDX_41AD8DDA3544AD9E');
        $this->addSql('DROP INDEX IDX_41AD8DDA3DA5256D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__medical_history_image AS SELECT medical_history_id, image_id FROM medical_history_image');
        $this->addSql('DROP TABLE medical_history_image');
        $this->addSql('CREATE TABLE medical_history_image (medical_history_id INTEGER NOT NULL, image_id INTEGER NOT NULL, PRIMARY KEY(medical_history_id, image_id))');
        $this->addSql('INSERT INTO medical_history_image (medical_history_id, image_id) SELECT medical_history_id, image_id FROM __temp__medical_history_image');
        $this->addSql('DROP TABLE __temp__medical_history_image');
        $this->addSql('CREATE INDEX IDX_41AD8DDA3544AD9E ON medical_history_image (medical_history_id)');
        $this->addSql('CREATE INDEX IDX_41AD8DDA3DA5256D ON medical_history_image (image_id)');
        $this->addSql('DROP INDEX IDX_10C31F866B899279');
        $this->addSql('DROP INDEX IDX_10C31F862902E187');
        $this->addSql('DROP INDEX IDX_10C31F86ECAB15B3');
        $this->addSql('DROP INDEX IDX_10C31F86DA6A219');
        $this->addSql('CREATE TEMPORARY TABLE __temp__rdv AS SELECT id, patient_id, symptomes_id, travel_id, place_id, date, result FROM rdv');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('CREATE TABLE rdv (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, patient_id INTEGER NOT NULL, symptomes_id INTEGER NOT NULL, travel_id INTEGER DEFAULT NULL, place_id INTEGER NOT NULL, date DATETIME NOT NULL, result VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO rdv (id, patient_id, symptomes_id, travel_id, place_id, date, result) SELECT id, patient_id, symptomes_id, travel_id, place_id, date, result FROM __temp__rdv');
        $this->addSql('DROP TABLE __temp__rdv');
        $this->addSql('CREATE INDEX IDX_10C31F866B899279 ON rdv (patient_id)');
        $this->addSql('CREATE INDEX IDX_10C31F862902E187 ON rdv (symptomes_id)');
        $this->addSql('CREATE INDEX IDX_10C31F86ECAB15B3 ON rdv (travel_id)');
        $this->addSql('CREATE INDEX IDX_10C31F86DA6A219 ON rdv (place_id)');
        $this->addSql('DROP INDEX IDX_FC505645DA6A219');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tester AS SELECT id, place_id, firstname, lastname, identifier, position, elecmail FROM tester');
        $this->addSql('DROP TABLE tester');
        $this->addSql('CREATE TABLE tester (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, place_id INTEGER DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, identifier VARCHAR(255) NOT NULL, position VARCHAR(255) NOT NULL, elecmail VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO tester (id, place_id, firstname, lastname, identifier, position, elecmail) SELECT id, place_id, firstname, lastname, identifier, position, elecmail FROM __temp__tester');
        $this->addSql('DROP TABLE __temp__tester');
        $this->addSql('CREATE INDEX IDX_FC505645DA6A219 ON tester (place_id)');
        $this->addSql('DROP INDEX IDX_1DD7EE8CDA6A219');
        $this->addSql('CREATE TEMPORARY TABLE __temp__times AS SELECT id, place_id, time_begin, time_finish FROM times');
        $this->addSql('DROP TABLE times');
        $this->addSql('CREATE TABLE times (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, place_id INTEGER NOT NULL, time_begin DATETIME NOT NULL, time_finish DATETIME NOT NULL)');
        $this->addSql('INSERT INTO times (id, place_id, time_begin, time_finish) SELECT id, place_id, time_begin, time_finish FROM __temp__times');
        $this->addSql('DROP TABLE __temp__times');
        $this->addSql('CREATE INDEX IDX_1DD7EE8CDA6A219 ON times (place_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__travel AS SELECT id, flydate, destination FROM travel');
        $this->addSql('DROP TABLE travel');
        $this->addSql('CREATE TABLE travel (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, destination VARCHAR(255) NOT NULL, fly_date DATETIME NOT NULL)');
        $this->addSql('INSERT INTO travel (id, fly_date, destination) SELECT id, flydate, destination FROM __temp__travel');
        $this->addSql('DROP TABLE __temp__travel');
    }
}
