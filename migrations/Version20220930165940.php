<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220930165940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__option AS SELECT id, option FROM option');
        $this->addSql('DROP TABLE option');
        $this->addSql('CREATE TABLE option (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, option_key VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO option (id, option_key) SELECT id, option FROM __temp__option');
        $this->addSql('DROP TABLE __temp__option');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__option AS SELECT id FROM option');
        $this->addSql('DROP TABLE option');
        $this->addSql('CREATE TABLE option (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, option VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO option (id) SELECT id FROM __temp__option');
        $this->addSql('DROP TABLE __temp__option');
    }
}
