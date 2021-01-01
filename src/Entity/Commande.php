<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Participant::class, inversedBy="user")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Matiere::class, inversedBy="commandes")
     */
    private $matierPos;

    public function __construct()
    {
        $this->matierPos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Participant
    {
        return $this->user;
    }

    public function setUser(?Participant $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Matiere[]
     */
    public function getMatierPos(): Collection
    {
        return $this->matierPos;
    }

    public function addMatierPo(Matiere $matierPo): self
    {
        if (!$this->matierPos->contains($matierPo)) {
            $this->matierPos[] = $matierPo;
        }

        return $this;
    }

    public function removeMatierPo(Matiere $matierPo): self
    {
        $this->matierPos->removeElement($matierPo);

        return $this;
    }
}
