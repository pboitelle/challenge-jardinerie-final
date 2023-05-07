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
#[ApiResource(
    security: 'is_granted("ROLE_ADMIN")',
)]
#[Post()]
#[Get()]
#[Patch()]
#[Delete()]
#[Put(
    denormalizationContext: ['groups' => 'plante:write'],
    normalizationContext: ['groups' => 'plante:read'],
)]
#[GetCollection(
    paginationEnabled: false,
    uriTemplate: '/plantes',
    name: 'plantes_list',
    openapiContext: [
        'summary' => 'Liste des plantes',
        'description' => 'Retourne la liste des plantes',
    ],
)]
class Plante
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['plante:write'])]
    private ?string $espece = null;

    #[ORM\Column(length: 255)]
    #[Groups(['plante:write'])]
    private ?string $genre = null;

    #[ORM\OneToOne(mappedBy: 'plante', cascade: ['persist', 'remove'])]
    private ?Blog $blog = null;

    #[ORM\OneToMany(mappedBy: 'plante', targetEntity: Item::class, orphanRemoval: true)]
    private Collection $items;

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
}
