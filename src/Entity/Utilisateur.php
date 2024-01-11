<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $nom = null;

    #[ORM\Column(length: 25)]
    private ?string $prenom = null;

    #[ORM\Column(length: 50)]
    private ?string $mail = null;

    #[ORM\Column(length: 60)]
    private ?string $mdp = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $tel = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\ManyToOne(targetEntity: Roles::class)]
    #[ORM\JoinColumn(name: "id_role", referencedColumnName: "id")]
    private ?Roles $idRole = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getIdRole(): ?Roles
    {
        return $this->idRole;
    }

    public function setIdRole(?Roles $idRole): static
    {
        $this->idRole = $idRole;

        return $this;
    }

    public function getRoles(): array
    {
        // Retournez ici les rôles de l'utilisateur sous forme de tableau
        return ['ROLE_USER']; // Par exemple, vous pouvez avoir un rôle utilisateur par défaut
    }

    public function eraseCredentials()
    {
        // Cette méthode peut rester vide, car elle est généralement utilisée pour effacer des données sensibles, ce qui n'est pas nécessaire ici.
    }

    public function getPassword(): ?string
    {
        return $this->mdp;
    }

    public function getUserIdentifier(): string
    {
        return $this->mail;
    }
}
