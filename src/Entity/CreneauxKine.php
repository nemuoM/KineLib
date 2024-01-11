<?php

namespace App\Entity;

use App\Repository\CreneauxKineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreneauxKineRepository::class)]
class CreneauxKine
{
    #[ORM\Id]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Kine $idKine = null;

    #[ORM\Id]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Creneaux $idCreneaux = null;

    public function getIdKine(): ?Kine
    {
        return $this->idKine;
    }

    public function setIdKine(?Kine $idKine): self
    {
        $this->idKine = $idKine;

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
