<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191211085558 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__discipline AS SELECT id, title, code FROM discipline');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('CREATE TABLE discipline (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, code VARCHAR(255) DEFAULT NULL, categorie VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO discipline (id, title, code) SELECT id, title, code FROM __temp__discipline');
        $this->addSql('DROP TABLE __temp__discipline');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__discipline AS SELECT id, title, code FROM discipline');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('CREATE TABLE discipline (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO discipline (id, title, code) SELECT id, title, code FROM __temp__discipline');
        $this->addSql('DROP TABLE __temp__discipline');
    }
}
