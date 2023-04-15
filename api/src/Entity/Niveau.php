<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\NiveauRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NiveauRepository::class)]
#[ApiResource]
class Niveau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $niveau = null;

    #[ORM\Column(length: 7)]
    private ?string $color = null;

    #[ORM\Column]
    private ?int $taux_drop = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getTauxDrop(): ?int
    {
        return $this->taux_drop;
    }

    public function setTauxDrop(int $taux_drop): self
    {
        $this->taux_drop = $taux_drop;

        return $this;
    }
}
