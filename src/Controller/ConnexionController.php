<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\InscriptionType;
use App\Entity\Utilisateur;
use App\Entity\Roles;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authenticator\FormLoginAuthenticator;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ConnexionController extends AbstractController
{
    #[Route('/', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Si l'utilisateur est déjà connecté, redirigez-le
        if ($this->getUser()) {
            return $this->redirectToRoute('app_accueil'); 
        }

        // Gestion de la connexion
        $error = $authenticationUtils->getLastAuthenticationError(); // Récupère les erreurs d'authentification précédentes
        $lastUsername = $authenticationUtils->getLastUsername(); // Récupère le dernier nom d'utilisateur saisi

        return $this->render('connexion/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, UserAuthenticatorInterface $userAuthenticator): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(InscriptionType::class, $utilisateur); // Crée un formulaire d'inscription
        $form->handleRequest($request); // Gère les données soumises dans le formulaire

        if ($form->isSubmitted() && $form->isValid()) { // Vérifie si le formulaire a été soumis et est valide
            $role = $entityManager->getRepository(Roles::class)->find(2); // Recherche un rôle dans la base de données

            $utilisateur->setIdRole($role); // Définit le rôle de l'utilisateur

            // Encode le mot de passe de l'utilisateur
            $utilisateur->setMdp(
                $passwordHasher->hashPassword(
                    $utilisateur,
                    $form->get('mdp')->getData()
                )
            );

            $entityManager->persist($utilisateur); // Persiste l'objet utilisateur dans la base de données
            $entityManager->flush(); // Enregistre les modifications en base de données

            // Connecte l'utilisateur après l'inscription
            return $this->redirectToRoute('app_login');
        }

        return $this->render('connexion/inscription.html.twig', [
            'inscriptionForm' => $form->createView(),
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(AuthenticationUtils $authenticationUtils): Response
    {
        // Ajoutez ici votre logique personnalisée, par exemple, journalisez la déconnexion.

        // Déconnexion de l'utilisateur
        $this->get('security.token_storage')->setToken(null);
        $this->get('session')->invalidate();

        return $this->redirectToRoute('app_login'); // Redirige vers la page de connexion ou une autre page de votre choix.
    }
}
