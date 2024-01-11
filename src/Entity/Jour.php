<?php

namespace App\Entity;

use App\Repository\JourRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JourRepository::class)]
class Jour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    private ?string $libelle = null;

    public function __construct()
    {
        $this->idCreneaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Creneaux>
     */
    public function getIdCreneaux(): Collection
    {
        return $this->idCreneaux;
    }

    public function addIdCreneaux(Creneaux $idCreneaux): static
    {
        if (!$this->idCreneaux->contains($idCreneaux)) {
            $this->idCreneaux->add($idCreneaux);
            $idCreneaux->setIdJour($this);
        }

        return $this;
    }

    public function removeIdCreneaux(Creneaux $idCreneaux): static
    {
        if ($this->idCreneaux->removeElement($idCreneaux)) {
            // set the owning side to null (unless already changed)
            if ($idCreneaux->getIdJour() === $this) {
                $idCreneaux->setIdJour(null);
            }
        }

        return $this;
    }
}
