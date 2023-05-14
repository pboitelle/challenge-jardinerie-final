<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\GetCollection;

use App\Controller\CreateMarketController;
use App\Controller\MarketsController;

use Symfony\Component\Serializer\Annotation\Groups;

use App\Repository\MarketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarketRepository::class)]
#[ApiResource()]
#[Get(
    uriTemplate: '/markets/{id}',
    name: 'markets_get',
    openapiContext: [
        'summary' => 'Récupérer un item sur le market de l\'utilisateur connecté',
        'description' => 'Récupérer un item sur le market de l\'utilisateur connecté',
    ],
    security: 'is_granted("ROLE_USER") and is_granted("MARKET_GET", object)',
    normalizationContext: [
        'groups' => ['item:read'],
        'openapi_definition_name' => 'Collection<market>',
        'skip_null_values' => true,
        'include_user_id' => true,
        'max_depth' => 1,
    ],
)]
#[GetCollection(
    paginationEnabled: false,
    uriTemplate: '/markets',
    name: 'market_list',
    openapiContext: [
        'summary' => 'Liste des items en vente sur le market',
        'description' => 'Liste des items en vente sur le market',
    ],
    security: 'is_granted("ROLE_USER")',
    controller: MarketsController::class,
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
#[Post(
    uriTemplate: '/markets',
    name: 'markets_post',
    controller: CreateMarketController::class,
    openapiContext: [
        'summary' => 'Créer un item sur le market',
        'description' => 'Créer un item sur le market',
    ],
    security: 'is_granted("ROLE_USER")',
    denormalizationContext: ['groups' => 'market:write'],
)]
#[Patch(
    uriTemplate: '/markets/{id}',
    name: 'markets_patch',
    openapiContext: [
        'summary' => 'Editer son item sur le market',
        'description' => 'Editer son item sur le market',
    ],
    security: 'is_granted("ROLE_USER") and is_granted("MARKET_GET", object)',
    denormalizationContext: ['groups' => 'market:write:prix'],
)]
#[Delete(
    uriTemplate: '/markets/{id}',
    name: 'markets_delete',
    openapiContext: [
        'summary' => 'Supprimer son item sur le market',
        'description' => 'Supprimer son item sur le market',
    ],
    security: 'is_granted("ROLE_USER") and is_granted("MARKET_GET", object)',
)]
class Market
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['market:read', 'item:read', 'user:vente:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'markets')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['market:read'])]
    private ?User $user_id = null;

    #[ORM\OneToOne(inversedBy: 'market')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['market:read', 'item:read', 'market:write', 'user:read'])]
    private ?Item $item_id = null;

    #[ORM\Column]
    #[Groups(['market:read', 'market:write', 'item:read', 'market:write:prix'])]
    private ?int $prix = null;

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
