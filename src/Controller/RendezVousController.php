<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\KineRepository;
use App\Repository\CreneauxKineRepository;
use App\Repository\JourRepository;
use App\Repository\RendezVousRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Kine;
use App\Entity\RendezVous;
use App\Entity\Utilisateur;
use App\Entity\Creneaux;
use App\Entity\Statut;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class RendezVousController extends AbstractController
{
    private $managerRegistry;
    private $security;

    public function __construct(ManagerRegistry $managerRegistry, Security $security)
    {
        $this->managerRegistry = $managerRegistry;
        $this->security = $security;
    }

    #[Route('/priserendezvous', name: 'app_priserdv')]
    public function priseRdv(KineRepository $kineRepository, JourRepository $jourRepo): Response
    {
        $lesKines = $kineRepository->findAll();
        $lesJours = $jourRepo->findAll();

        return $this->render('rendez_vous/index.html.twig', [
            'controller_name' => 'RendezVousController',
            'lesKines' => $lesKines,
            'lesJours' => $lesJours,
        ]);
    }

    #[Route('/agenda/{kineId}', name: 'kine_agenda')]
    public function agenda(int $kineId, CreneauxKineRepository $creneauxKineRepo, JourRepository $jourRepo, RendezVousRepository $rdvRepo): Response
    {
        $today = new \DateTime(); // Aujourd'hui
        $startOfWeek = (new \DateTime())->modify('Monday this week'); // Lundi de cette semaine
        $endOfWeek = (new \DateTime())->modify('Friday this week'); // Vendredi de cette semaine

        // Si aujourd'hui est après le vendredi de cette semaine, passez à la semaine suivante
        if ($today > $endOfWeek) {
            $startOfWeek->modify('+7 days'); // Déplacez le début de la semaine à lundi prochain
        }

        $datesDeLaSemaine = [];
        for ($i = 0; $i < 5; $i++) {
            // Clone $startOfWeek et ajoutez le nombre de jours correspondant
            $date = clone $startOfWeek;
            $date->add(new \DateInterval("P{$i}D"));
            $datesDeLaSemaine[] = $date;
        }

        $lesJours = $jourRepo->findAll();
        $lesRdv = $rdvRepo->findAll();
        $creneaux = $creneauxKineRepo->findByKineId($kineId);

        return $this->render('rendez_vous/_creneaux.html.twig', [
            'creneaux' => $creneaux,
            'lesJours' => $lesJours,
            'datesDeLaSemaine' => $datesDeLaSemaine,
            'lesRdv' => $lesRdv,
            'idKine' => $kineId,
        ]);
    }

    public function loadWeek(Request $request, CreneauxRepository $creneauxRepo): JsonResponse
    {
        $weekStart = new \DateTime($request->query->get('start'));
        $weekEnd = (clone $weekStart)->modify('+6 days');

        // Supposons que findAvailableCreneauxForWeek renvoie un tableau d'objets Creneaux
        $creneaux = $creneauxRepo->findAvailableCreneauxForWeek($weekStart, $weekEnd);

        // Transformer les données pour le front-end
        $creneauxData = array_map(function ($creneau) {
            return [
                'id' => $creneau->getId(),
                'heureDebut' => $creneau->getHeureDebut()->format('H:i'),
            ];
        }, $creneaux);

        // Renvoyer les données en JSON
        return $this->json($creneauxData);
    }

    #[Route('/ajouterrendezvous', name: 'ajouter_rendezvous', methods: ['POST'])]
    public function ajouterRendezVous(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupérer les données de la requête JSON et les décoder
        $data = json_decode($request->getContent(), true);

        // Extraire les données après le décodage JSON
        $creneauId = $data['creneauId'] ?? null;
        $kineId = $data['kineId'] ?? null;
        $userId = $this->getUser()->getId(); // Récupérez l'ID de l'utilisateur actuellement connecté
        $statutId = 1; // Statut par défaut
        $dateRdv = isset($data['dateRdv']) ? new \DateTime($data['dateRdv']) : null;

        // Vérifier si tous les ID sont présents
        if (!$kineId || !$userId || !$creneauId || !$dateRdv) {
            return $this->json(['status' => 'error', 'message' => 'ID manquant ou date de rendez-vous invalide']);
        }

        // Trouver les entités correspondantes
        $kine = $entityManager->getRepository(Kine::class)->find($kineId);
        $utilisateur = $entityManager->getRepository(Utilisateur::class)->find($userId);
        $creneaux = $entityManager->getRepository(Creneaux::class)->find($creneauId);

        // Vérifier si les entités ont été trouvées
        if (!$kine || !$utilisateur || !$creneaux) {
            return $this->json(['status' => 'error', 'message' => 'Entité non trouvée']);
        }

        // Créer et configurer la nouvelle entité RendezVous
        $rendezVous = new RendezVous();
        $rendezVous->setIdKine($kine)
                ->setIdUtilisateur($utilisateur)
                ->setIdStatut($entityManager->getRepository(Statut::class)->find($statutId)) // Statut par défaut
                ->setIdCreneaux($creneaux)
                ->setDateRdv($dateRdv); // Assurez-vous que RendezVous a un setter pour dateDebut

        // Persister l'entité dans la base de données
        $entityManager->persist($rendezVous);
        $entityManager->flush();

        // Réponse JSON
        return $this->json(['status' => 'success', 'message' => 'Rendez-vous ajouté']);
    }
}
