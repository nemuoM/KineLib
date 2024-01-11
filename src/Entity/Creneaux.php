<?php

namespace App\Entity;

use App\Repository\CreneauxRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreneauxRepository::class)]
class Creneaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Jour $idJour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $horaireD = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $horaireF = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdJour(): ?Jour
    {
        return $this->idJour;
    }

    public function setIdJour(?Jour $idJour): static
    {
        $this->idJour = $idJour;

        return $this;
    }

    public function getHoraireD(): ?\DateTimeInterface
    {
        return $this->horaireD;
    }

    public function setHoraireD(\DateTimeInterface $horaireD): static
    {
        $this->horaireD = $horaireD;

        return $this;
    }

    public function getHoraireF(): ?\DateTimeInterface
    {
        return $this->horaireF;
    }

    public function setHoraireF(\DateTimeInterface $horaireF): static
    {
        $this->horaireF = $horaireF;

        return $this;
    }
}
