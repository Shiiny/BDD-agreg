<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191213152159 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE concours (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(255) DEFAULT NULL, code_t VARCHAR(255) DEFAULT NULL, public VARCHAR(255) DEFAULT NULL, code_p VARCHAR(255) DEFAULT NULL, material VARCHAR(255) DEFAULT NULL, code_m VARCHAR(255) DEFAULT NULL, categorie VARCHAR(255) DEFAULT NULL, code_c VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, code_cohorte VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE cours_concours (cours_id INTEGER NOT NULL, concours_id INTEGER NOT NULL, PRIMARY KEY(cours_id, concours_id))');
        $this->addSql('CREATE TABLE teacher_concours (teacher_id INTEGER NOT NULL, concours_id INTEGER NOT NULL, PRIMARY KEY(teacher_id, concours_id))');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE concours');
        $this->addSql('DROP TABLE cours_concours');
        $this->addSql('DROP TABLE teacher_concours');
    }
}
