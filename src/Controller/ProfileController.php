<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\RendezVous;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;

class ProfileController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/profile', name: 'app_profile')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $dateActuelle = new \DateTime();

        $userId = $this->getUser()->getId();

        $utilisateur = $entityManager->getRepository(Utilisateur::class)->find($userId);
        $rendezVous = $entityManager->getRepository(RendezVous::class)->findBy(
        ['idUtilisateur' => $utilisateur],
        ['dateRdv' => 'ASC'] // Tri croissant par date de rendez-vous
    );

        return $this->render('profile/index.html.twig', [
            'dateActuelle' => $dateActuelle,
            'user' => $utilisateur,
            'rendezVous' => $rendezVous,
        ]);
    }
}
