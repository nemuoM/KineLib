<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Creneaux;
use App\Entity\Jour;
use App\Entity\Specialite;
use App\Entity\Kine;
use App\Entity\CreneauxKine;
use App\Entity\Statut;
use App\Entity\Roles;
use App\Entity\Utilisateur;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Création de mon utilisateur de base
        $user = new Utilisateur;
        $user->setNom("MORABET");
        $user->setPrenom("Abdelmoumen");
        $user->setMail("abdelmoumen.morabet@gmail.com");
        $user->setMdp('$2y$13$muETEQFSs336Y95vZAC1V.zLpJllAYfun.Hzsa9y56qQ0bBvXGhj2');
        $user->setTel('0784603494');
        $user->setDateNaissance('2003-11-17');
        $user->setIdRole(1);

        $manager->persist($user);
        $manager->flush();


        // Définissez ici les différents statuts de rendez-vous
        $statuts = ['Confirmé', 'Annulé', 'Terminé'];

        foreach ($statuts as $libStatut) {
            $statut = new Statut();
            $statut->setLibelle($libStatut);
            $manager->persist($statut);
        }

        $manager->flush();

        $roleNames = ['Admin', 'User'];

        foreach ($roleNames as $roleName) {
            $role = new Roles();
            $role->setLibelle($roleName);
            $manager->persist($role);
        }

        $manager->flush();

        // Insertion des jours de la semaine
        $jours = [
            'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'
        ];

        foreach ($jours as $libelle) {
            $jour = new Jour();
            $jour->setLibelle($libelle);
            $manager->persist($jour);
        }
        
        // Flush les jours avant de créer les créneaux
        $manager->flush();



        // Création des créneaux horaires
        $heuresTravail = range(9, 16); // De 9h à 16h (pour finir à 17h)
        $joursEntities = $manager->getRepository(Jour::class)->findAll();

        foreach ($joursEntities as $jourEntity) {
            foreach ($heuresTravail as $heureDebut) {
                // Sauter la pause de midi
                if ($heureDebut == 12 || $heureDebut == 13) {
                    continue; // Pause de 12h à 14h
                }
                
                $creneau = new Creneaux();
                $creneau->setIdJour($jourEntity);
                $creneau->setHoraireD(new \DateTimeImmutable("{$heureDebut}:00:00"));
                $creneau->setHoraireF(new \DateTimeImmutable(($heureDebut + 1) . ":00:00"));
                $manager->persist($creneau);
            }
        }


        // Insertion des spécialités
        $specialite1 = new Specialite();
        $specialite1->setLibelle('Orthopédie');
        $specialite1->setDescription('Spécialité médicale dédiée au diagnostic, au traitement, à la prévention et à la réhabilitation des maladies, des blessures et des déformations des os, des articulations, des muscles, des tendons, des nerfs et de la peau.');
        $manager->persist($specialite1);

        $specialite2 = new Specialite();
        $specialite2->setLibelle('Neurologie');
        $specialite2->setDescription("Branche de la médecine traitant des troubles du système nerveux. Elle s'occupe de la prévention, du diagnostic, du traitement et de la rééducation des maladies touchant le système nerveux central et périphérique");
        $manager->persist($specialite2);

        $specialite3 = new Specialite();
        $specialite3->setLibelle('Pédiatrie');
        $specialite3->setDescription("Domaine médical qui s'occupe de la santé physique, mentale et sociale des enfants depuis la naissance jusqu'à l'adolescence. La pédiatrie vise à réduire le taux de mortalité infantile, à contrôler la propagation des maladies infectieuses et à promouvoir un mode de vie sain.");
        $manager->persist($specialite3);


        // Insertion des kinés
        $kine1 = new Kine();
        $kine1->setNom('Dupont');
        $kine1->setPrenom('Jean');
        $kine1->setSpecialite($specialite1); 
        $manager->persist($kine1);

        $kine2 = new Kine();
        $kine2->setNom('Martin');
        $kine2->setPrenom('Alice');
        $kine2->setSpecialite($specialite2); 
        $manager->persist($kine2);

        $kine3 = new Kine();
        $kine3->setNom('Durand');
        $kine3->setPrenom('Luc');
        $kine3->setSpecialite($specialite3); 
        $manager->persist($kine3);



        // Flush toutes les entités
        $manager->flush();


        // Associer des créneaux aux kinés
        $creneaux = $manager->getRepository(Creneaux::class)->findAll();
        $kines = $manager->getRepository(Kine::class)->findAll();

        foreach ($kines as $kine) {
            foreach ($creneaux as $creneau) {
                $creneauxKine = new CreneauxKine();
                $creneauxKine->setIdKine($kine);
                $creneauxKine->setIdCreneaux($creneau);
                $manager->persist($creneauxKine);
            }
        }

        // Flush les modifications
        $manager->flush();
    }
}
