<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231228155957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE kine DROP FOREIGN KEY FK_4CC38C4F9FBD3195');
        $this->addSql('DROP INDEX IDX_4CC38C4F9FBD3195 ON kine');
        $this->addSql('ALTER TABLE kine CHANGE idSpecialite id_specialite_id INT NOT NULL');
        $this->addSql('ALTER TABLE kine ADD CONSTRAINT FK_4CC38C4F9FBD3195 FOREIGN KEY (id_specialite_id) REFERENCES specialite (id)');
        $this->addSql('CREATE INDEX IDX_4CC38C4F9FBD3195 ON kine (id_specialite_id)');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A76158423');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AC6EE5C49');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A5641E2BC');
        $this->addSql('DROP INDEX IDX_65E8AA0A5641E2BC ON rendez_vous');
        $this->addSql('DROP INDEX IDX_65E8AA0AC6EE5C49 ON rendez_vous');
        $this->addSql('DROP INDEX IDX_65E8AA0A76158423 ON rendez_vous');
        $this->addSql('ALTER TABLE rendez_vous ADD id_kine_id INT NOT NULL, ADD id_utilisateur_id INT NOT NULL, ADD id_statut_id INT NOT NULL, DROP idKine, DROP idUtilisateur, DROP idStatut');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A76158423 FOREIGN KEY (id_statut_id) REFERENCES statut (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AC6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A5641E2BC FOREIGN KEY (id_kine_id) REFERENCES kine (id)');
        $this->addSql('CREATE INDEX IDX_65E8AA0A5641E2BC ON rendez_vous (id_kine_id)');
        $this->addSql('CREATE INDEX IDX_65E8AA0AC6EE5C49 ON rendez_vous (id_utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_65E8AA0A76158423 ON rendez_vous (id_statut_id)');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B389E8BDC');
        $this->addSql('DROP INDEX IDX_1D1C63B389E8BDC ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD id_role INT DEFAULT NULL, DROP idRole');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3DC499668 FOREIGN KEY (id_role) REFERENCES roles (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3DC499668 ON utilisateur (id_role)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE kine DROP FOREIGN KEY FK_4CC38C4F9FBD3195');
        $this->addSql('DROP INDEX IDX_4CC38C4F9FBD3195 ON kine');
        $this->addSql('ALTER TABLE kine CHANGE id_specialite_id idSpecialite INT NOT NULL');
        $this->addSql('ALTER TABLE kine ADD CONSTRAINT FK_4CC38C4F9FBD3195 FOREIGN KEY (idSpecialite) REFERENCES specialite (id)');
        $this->addSql('CREATE INDEX IDX_4CC38C4F9FBD3195 ON kine (idSpecialite)');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A5641E2BC');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AC6EE5C49');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A76158423');
        $this->addSql('DROP INDEX IDX_65E8AA0A5641E2BC ON rendez_vous');
        $this->addSql('DROP INDEX IDX_65E8AA0AC6EE5C49 ON rendez_vous');
        $this->addSql('DROP INDEX IDX_65E8AA0A76158423 ON rendez_vous');
        $this->addSql('ALTER TABLE rendez_vous ADD idKine INT NOT NULL, ADD idUtilisateur INT NOT NULL, ADD idStatut INT NOT NULL, DROP id_kine_id, DROP id_utilisateur_id, DROP id_statut_id');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A5641E2BC FOREIGN KEY (idKine) REFERENCES kine (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AC6EE5C49 FOREIGN KEY (idUtilisateur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A76158423 FOREIGN KEY (idStatut) REFERENCES statut (id)');
        $this->addSql('CREATE INDEX IDX_65E8AA0A5641E2BC ON rendez_vous (idKine)');
        $this->addSql('CREATE INDEX IDX_65E8AA0AC6EE5C49 ON rendez_vous (idUtilisateur)');
        $this->addSql('CREATE INDEX IDX_65E8AA0A76158423 ON rendez_vous (idStatut)');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3DC499668');
        $this->addSql('DROP INDEX IDX_1D1C63B3DC499668 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD idRole INT NOT NULL, DROP id_role');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B389E8BDC FOREIGN KEY (idRole) REFERENCES roles (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B389E8BDC ON utilisateur (idRole)');
    }
}
