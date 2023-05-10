<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\GetCollection;

use Symfony\Component\Serializer\Annotation\Groups;

use App\Repository\ItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ApiResource(
    denormalizationContext: ['groups' => ['item:write']],
    normalizationContext: ['groups' => ['item:read']]
)]
#[Patch(
    uriTemplate: '/items/{id}',
    name: 'item_patch',
    openapiContext: [
        'summary' => 'Modifier un item',
        'description' => 'Modifier un item',
    ],
    denormalizationContext: ['groups' => 'item:write'],
    security: 'is_granted("ROLE_USER") and object.getUserId() == user',
)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['item:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['item:read', 'item:write'])]
    private ?bool $isPlanted = null;

    #[ORM\Column]
    #[Groups(['item:read'])]
    private ?bool $hasGrown = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['item:read'])]
    private ?Niveau $niveau = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['item:read'])]
    private ?Plante $plante = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?User $user_id = null;

    #[ORM\OneToOne(mappedBy: 'item_id', cascade: ['persist', 'remove'])]
    private ?Market $market = null;

    #[ORM\OneToOne(mappedBy: 'item', cascade: ['persist', 'remove'])]
    private ?Vente $vente = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsPlanted(): ?bool
    {
        return $this->isPlanted;
    }

    public function setIsPlanted(bool $isPlanted): self
    {
        $this->isPlanted = $isPlanted;

        return $this;
    }

    public function isHasGrown(): ?bool
    {
        return $this->hasGrown;
    }

    public function setHasGrown(bool $hasGrown): self
    {
        $this->hasGrown = $hasGrown;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getPlante(): ?Plante
    {
        return $this->plante;
    }

    public function setPlante(?Plante $plante): self
    {
        $this->plante = $plante;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getMarket(): ?Market
    {
        return $this->market;
    }

    public function setMarket(Market $market): self
    {
        // set the owning side of the relation if necessary
        if ($market->getItemId() !== $this) {
            $market->setItemId($this);
        }

        $this->market = $market;

        return $this;
    }

    public function getVente(): ?Vente
    {
        return $this->vente;
    }

    public function setVente(Vente $vente): self
    {
        // set the owning side of the relation if necessary
        if ($vente->getItem() !== $this) {
            $vente->setItem($this);
        }

        $this->vente = $vente;

        return $this;
    }
}
