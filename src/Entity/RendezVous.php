<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
class RendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Kine $idKine = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $idUtilisateur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Statut $idStatut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateRdv = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Creneaux $idCreneaux = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRdv(): ?\DateTimeInterface
    {
        return $this->dateRdv;
    }

    public function setDateRdv(\DateTimeInterface $dateRdv): static
    {
        $this->dateRdv = $dateRdv;

        return $this;
    }
    public function getIdKine(): ?Kine
    {
        return $this->idKine;
    }

    public function setIdKine(?Kine $idKine): static
    {
        $this->idKine = $idKine;

        return $this;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $idUtilisateur): static
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    public function getIdStatut(): ?Statut
    {
        return $this->idStatut;
    }

    public function setIdStatut(?Statut $idStatut): static
    {
        $this->idStatut = $idStatut;

        return $this;
    }

    public function getIdCreneaux(): ?Creneaux
    {
        return $this->idCreneaux;
    }

    public function setIdCreneaux(?Creneaux $idCreneaux): self
    {
        $this->idCreneaux = $idCreneaux;

        return $this;
    }
}
