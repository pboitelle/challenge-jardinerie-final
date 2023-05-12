<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\Serializer\Annotation\Groups;

use App\Repository\PlanteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanteRepository::class)]
#[ApiResource()]
#[Post()]
#[Get()]
#[Patch()]
#[Delete()]
#[Put(
    denormalizationContext: ['groups' => 'plante:write'],
    normalizationContext: ['groups' => 'plante:read'],
    security: 'is_granted("ROLE_ADMIN")',
    openapiContext: [
        'summary' => 'Modifier une plante',
        'description' => 'Modifier une plante',
    ],
)]
#[GetCollection(
    paginationEnabled: false,
    uriTemplate: '/plantes',
    name: 'plantes_list',
    security: 'is_granted("ROLE_BLOGER")',
    openapiContext: [
        'summary' => 'Liste des plantes',
        'description' => 'Retourne la liste des plantes',
    ],
    denormalizationContext: [
        'groups' => ['user:read', 'user:read:plante'],
        'openapi_definition_name' => 'List<plantes>',
        'skip_null_values' => false,
        'max_depth' => 1,
    ],
    normalizationContext: [
        'groups' => ['user:read:plante'],
        'openapi_definition_name' => 'Detail<blogs>',
        'skip_null_values' => false,
        'max_depth' => 1,
    ]
)]
class Plante
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read', 'user:read:plante'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['plante:write', 'user:read', 'user:read:plante', 'item:read', 'market:read'])]
    private ?string $espece = null;

    #[ORM\Column(length: 255)]
    #[Groups(['plante:write', 'user:read', 'user:read:plante', 'item:read'])]
    private ?string $genre = null;

    #[ORM\OneToOne(mappedBy: 'plante', cascade: ['persist', 'remove'])]
    #[Groups(['user:read', 'user:read:plante', 'item:read'])]
    private ?Blog $blog = null;

    #[ORM\OneToMany(mappedBy: 'plante', targetEntity: Item::class, orphanRemoval: true)]
    private Collection $items;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:write', 'user:read', 'user:read:plante', 'item:read', 'market:read'])]
    private ?string $image_url = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEspece(): ?string
    {
        return $this->espece;
    }

    public function setEspece(string $espece): self
    {
        $this->espece = $espece;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getBlog(): ?Blog
    {
        return $this->blog;
    }

    public function setBlog(Blog $blog): self
    {
        // set the owning side of the relation if necessary
        if ($blog->getPlante() !== $this) {
            $blog->setPlante($this);
        }

        $this->blog = $blog;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    public function setImageUrl(?string $image_url): self
    {
        $this->image_url = $image_url;

        return $this;
    }
}
