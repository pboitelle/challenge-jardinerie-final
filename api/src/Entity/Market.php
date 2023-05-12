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

use App\Repository\MarketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarketRepository::class)]
#[ApiResource()]
#[GetCollection(
    paginationEnabled: false,
    uriTemplate: '/markets',
    name: 'market_list',
    openapiContext: [
        'summary' => 'Liste des items en vente sur le market',
        'description' => 'Liste des items en vente sur le market',
    ],
    security: 'is_granted("ROLE_USER")',
    denormalizationContext: ['groups' => 'market:read'],
    normalizationContext: [
        'groups' => ['market:read'],
        'openapi_definition_name' => 'Collection<users>',
        'skip_null_values' => true,
        'include_user_id' => true,
        'max_depth' => 1,
    ],
    order: ['id' => 'DESC']
)]
class Market
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['market:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'markets')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['market:read'])]
    private ?User $user_id = null;

    #[ORM\OneToOne(inversedBy: 'market', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['market:read', 'item:read'])]
    private ?Item $item_id = null;

    #[ORM\Column]
    #[Groups(['market:read'])]
    private ?float $price = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getItemId(): ?Item
    {
        return $this->item_id;
    }

    public function setItemId(Item $item_id): self
    {
        $this->item_id = $item_id;

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
}
