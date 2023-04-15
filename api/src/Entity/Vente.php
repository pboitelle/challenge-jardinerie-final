<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\VenteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VenteRepository::class)]
#[ApiResource]
class Vente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ventes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $vendeur = null;

    #[ORM\ManyToOne(inversedBy: 'ventes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $acheteur = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\OneToOne(inversedBy: 'vente', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Item $item = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVendeur(): ?User
    {
        return $this->vendeur;
    }

    public function setVendeur(?User $vendeur): self
    {
        $this->vendeur = $vendeur;

        return $this;
    }

    public function getAcheteur(): ?User
    {
        return $this->acheteur;
    }

    public function setAcheteur(?User $acheteur): self
    {
        $this->acheteur = $acheteur;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(Item $item): self
    {
        $this->item = $item;

        return $this;
    }
}
