<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191128144647 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE cours (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, id_moodle INTEGER NOT NULL, discipline_id INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TABLE cours_teacher (cours_id INTEGER NOT NULL, teacher_id INTEGER NOT NULL, PRIMARY KEY(cours_id, teacher_id))');
        $this->addSql('CREATE TABLE discipline (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE formation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, code VARCHAR(50) NOT NULL)');
        $this->addSql('CREATE TABLE formation_cours (formation_id INTEGER NOT NULL, cours_id INTEGER NOT NULL, PRIMARY KEY(formation_id, cours_id))');
        $this->addSql('ALTER TABLE teacher ADD COLUMN discipline_id INTEGER DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE cours_teacher');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE formation_cours');
        $this->addSql('CREATE TEMPORARY TABLE __temp__teacher AS SELECT id, lastname, firstname, email, phone, created_at, id_moodle FROM teacher');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('CREATE TABLE teacher (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, id_moodle INTEGER NOT NULL)');
        $this->addSql('INSERT INTO teacher (id, lastname, firstname, email, phone, created_at, id_moodle) SELECT id, lastname, firstname, email, phone, created_at, id_moodle FROM __temp__teacher');
        $this->addSql('DROP TABLE __temp__teacher');
    }
}
