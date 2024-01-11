<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231120104516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE kine (id INT AUTO_INCREMENT NOT NULL, idSpecialite INT NOT NULL, nom VARCHAR(25) NOT NULL, prenom VARCHAR(25) NOT NULL, tel VARCHAR(15) NOT NULL, INDEX IDX_4CC38C4F9FBD3195 (idSpecialite), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, idKine INT NOT NULL, idUtilisateur INT NOT NULL, idStatut INT NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, note VARCHAR(60) NOT NULL, INDEX IDX_65E8AA0A5641E2BC (idKine), INDEX IDX_65E8AA0AC6EE5C49 (idUtilisateur), INDEX IDX_65E8AA0A76158423 (idStatut), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialite (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(15) NOT NULL, description VARCHAR(60) NOT NULL, dure TIME NOT NULL, tarif DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, idRole INT NOT NULL, nom VARCHAR(25) NOT NULL, prenom VARCHAR(25) NOT NULL, mail VARCHAR(50) NOT NULL, mdp VARCHAR(60) NOT NULL, tel VARCHAR(25) DEFAULT NULL, date_naissance DATE NOT NULL, note_medic VARCHAR(225) DEFAULT NULL, INDEX IDX_1D1C63B389E8BDC (idRole), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE kine ADD CONSTRAINT FK_4CC38C4F9FBD3195 FOREIGN KEY (idSpecialite) REFERENCES specialite (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A5641E2BC FOREIGN KEY (idKine) REFERENCES kine (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AC6EE5C49 FOREIGN KEY (idUtilisateur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A76158423 FOREIGN KEY (idStatut) REFERENCES statut (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B389E8BDC FOREIGN KEY (idRole) REFERENCES roles (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE kine DROP FOREIGN KEY FK_4CC38C4F9FBD3195');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A5641E2BC');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AC6EE5C49');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A76158423');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B389E8BDC');
        $this->addSql('DROP TABLE kine');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP TABLE statut');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
