<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
// Autres types de champ nécessaires...

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Ajout du champ 'nom' de type TextType avec des attributs spécifiques
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'nom-class', 'placeholder' => 'Votre nom']
            ])
            // Ajout du champ 'prenom' de type TextType avec des attributs spécifiques
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'prenom-class', 'placeholder' => 'Votre prénom']
            ])
            // Ajout du champ 'mail' de type EmailType avec des attributs spécifiques
            ->add('mail', EmailType::class, [
                'attr' => ['class' => 'mail-class', 'placeholder' => 'Votre adresse e-mail']
            ])
            // Ajout du champ 'mdp' de type PasswordType avec des attributs spécifiques
            ->add('mdp', PasswordType::class, [
                'attr' => ['class' => 'pwd-class', 'placeholder' => 'Votre mot de passe']
            ])
            // Ajout du champ 'tel' de type TelType (pour un numéro de téléphone) avec des attributs spécifiques
            ->add('tel', TelType::class, [
                'attr' => ['class' => 'tel-class', 'placeholder' => 'Votre numéro de téléphone']
            ])
            // Ajout du champ 'dateNaissance' de type DateType (pour une date de naissance) avec des attributs spécifiques
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text', // Permet de sélectionner une date via un seul champ de texte
                'attr' => ['class' => 'date-class'],
                // Vous pouvez ajouter d'autres options pour configurer le format de la date, etc.
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // Configuration des options du formulaire, en spécifiant la classe d'entité associée (Utilisateur)
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
