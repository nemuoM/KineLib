<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240102160051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creneaux_kine MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON creneaux_kine');
        $this->addSql('ALTER TABLE creneaux_kine DROP id');
        $this->addSql('ALTER TABLE creneaux_kine ADD PRIMARY KEY (id_kine_id, id_creneaux_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creneaux_kine ADD id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }
}
