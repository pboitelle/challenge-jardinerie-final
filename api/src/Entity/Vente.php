<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\GetCollection;

use App\Controller\CreateVenteController;

use App\Repository\VenteRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: VenteRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['vente:read']],
    denormalizationContext: ['groups' => ['vente:write']]
)]
#[Post(
    uriTemplate: '/ventes',
    name: 'vente_create',
    controller: CreateVenteController::class,
    openapiContext: [
        'summary' => 'Créer une vente',
        'description' => 'Créer une vente',
    ],
    security: 'is_granted("ROLE_USER")',
    denormalizationContext: ['groups' => 'vente:write']
)]
#[Delete(
    uriTemplate: '/ventes/{id}',
    name: 'vente_delete',
    openapiContext: [
        'summary' => 'Supprimer une vente',
        'description' => 'Supprimer une vente',
    ],
    normalizationContext: [
        'enable_max_depth' => 1,
    ],
    security: 'is_granted("ROLE_USER") and (object.getVendeur() == user or object.getAcheteur() == user)'
)]
class Vente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:vente:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ventes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['vente:read', 'vente:write', 'user:vente:read'])]
    private ?User $vendeur = null;

    #[ORM\ManyToOne(inversedBy: 'ventes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['user:vente:read'])]
    private ?User $acheteur = null;

    #[ORM\OneToOne(inversedBy: 'vente')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['vente:read', 'vente:write', 'user:vente:read'])]
    private ?Item $item = null;

    #[ORM\Column]
    #[Groups(['vente:write', 'user:vente:read'])]
    private ?int $prix = null;

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

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(Item $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
