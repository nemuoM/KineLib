<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240102155417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE creneaux (id INT AUTO_INCREMENT NOT NULL, id_jour_id INT NOT NULL, horaire_d TIME NOT NULL, horaire_f TIME NOT NULL, INDEX IDX_77F13C6DFC91C3A0 (id_jour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creneaux_kine (id INT AUTO_INCREMENT NOT NULL, id_kine_id INT NOT NULL, id_creneaux_id INT NOT NULL, INDEX IDX_1EC1FE675641E2BC (id_kine_id), INDEX IDX_1EC1FE678715EBB6 (id_creneaux_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jour (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE creneaux ADD CONSTRAINT FK_77F13C6DFC91C3A0 FOREIGN KEY (id_jour_id) REFERENCES jour (id)');
        $this->addSql('ALTER TABLE creneaux_kine ADD CONSTRAINT FK_1EC1FE675641E2BC FOREIGN KEY (id_kine_id) REFERENCES kine (id)');
        $this->addSql('ALTER TABLE creneaux_kine ADD CONSTRAINT FK_1EC1FE678715EBB6 FOREIGN KEY (id_creneaux_id) REFERENCES creneaux (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD id_creneaux_id INT NOT NULL, ADD date_rdv DATE NOT NULL, DROP date_debut, DROP date_fin, DROP note');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A8715EBB6 FOREIGN KEY (id_creneaux_id) REFERENCES creneaux (id)');
        $this->addSql('CREATE INDEX IDX_65E8AA0A8715EBB6 ON rendez_vous (id_creneaux_id)');
        $this->addSql('ALTER TABLE specialite DROP dure, DROP tarif');
        $this->addSql('ALTER TABLE utilisateur DROP note_medic');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A8715EBB6');
        $this->addSql('ALTER TABLE creneaux DROP FOREIGN KEY FK_77F13C6DFC91C3A0');
        $this->addSql('ALTER TABLE creneaux_kine DROP FOREIGN KEY FK_1EC1FE675641E2BC');
        $this->addSql('ALTER TABLE creneaux_kine DROP FOREIGN KEY FK_1EC1FE678715EBB6');
        $this->addSql('DROP TABLE creneaux');
        $this->addSql('DROP TABLE creneaux_kine');
        $this->addSql('DROP TABLE jour');
        $this->addSql('DROP INDEX IDX_65E8AA0A8715EBB6 ON rendez_vous');
        $this->addSql('ALTER TABLE rendez_vous ADD date_debut DATETIME NOT NULL, ADD date_fin DATETIME NOT NULL, ADD note VARCHAR(60) NOT NULL, DROP id_creneaux_id, DROP date_rdv');
        $this->addSql('ALTER TABLE specialite ADD dure TIME NOT NULL, ADD tarif DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD note_medic VARCHAR(225) DEFAULT NULL');
    }
}
