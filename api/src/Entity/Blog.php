<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\GetCollection;

use App\Controller\GetValidateBlogsController;
use App\Controller\CreateBlogController;

use App\Repository\BlogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BlogRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/blogs-validate',
            name: 'blogs-validate',
            controller: GetValidateBlogsController::class,
            openapiContext: [
                'summary' => 'Récupère la liste des blogs validés',
                'description' => 'Récupère la liste des blogs validés',
            ],
            security: 'is_granted("ROLE_USER")',
            paginationEnabled: false,
            denormalizationContext: ['groups' => 'user:read'],
            normalizationContext: [
                'groups' => ['user:read'],
                'openapi_definition_name' => 'Collection<blogs>',
                'skip_null_values' => true,
                'include_user_id' => true,
                'max_depth' => 1,
            ],
            order: ['created_at' => 'DESC'],
        )
    ]
)]
#[Put(
    uriTemplate: '/blogs/{id}',
    name: 'blogs_put',
    openapiContext: [
        'summary' => 'Modifier un blog',
        'description' => 'Modifier un blog',
    ],
    security: 'is_granted("ROLE_ADMIN")',
    denormalizationContext: ['groups' => 'user:edit'],
)]
#[Delete(
    uriTemplate: '/blogs/{id}',
    name: 'blogs_delete',
    openapiContext: [
        'summary' => 'Supprimer un blog',
        'description' => 'Supprimer un blog',
    ],
    security: 'is_granted("ROLE_ADMIN")',
)]
#[Post(
    uriTemplate: '/blogs',
    name: 'blogs_post',
    controller: CreateBlogController::class,
    openapiContext: [
        'summary' => 'Créer un blog',
        'description' => 'Créer un blog',
    ],
    security: 'is_granted("ROLE_BLOGER")',
    denormalizationContext: ['groups' => 'user:write'],
)]
#[Get(
    uriTemplate: '/blogs/{id}',
    name: 'blogs_get',
    openapiContext: [
        'summary' => 'Récupère un blog',
        'description' => 'Récupère un blog',
    ],
    security: 'is_granted("ROLE_USER")',
    denormalizationContext: ['groups' => 'user:read'],
    normalizationContext: [
        'groups' => ['user:read'],
        'openapi_definition_name' => 'Detail<blogs>',
        'skip_null_values' => true,
        'include_user_id' => true,
        'max_depth' => 1,
    ],
)]
#[GetCollection(
    uriTemplate: '/blogs',
    name: 'blogs',
    openapiContext: [
        'summary' => 'Récupère la liste des blogs',
        'description' => 'Récupère la liste des blogs',
    ],
    security: 'is_granted("ROLE_ADMIN")',
    paginationEnabled: false,
    denormalizationContext: ['groups' => 'user:read'],
    normalizationContext: [
        'groups' => ['user:read'],
        'openapi_definition_name' => 'Collection<blogs>',
        'skip_null_values' => true,
        'include_user_id' => true,
        'max_depth' => 1,
    ],
    order: ['created_at' => 'DESC'],
)]
class Blog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read', 'user:read:plante'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'user:write', 'user:edit'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'user:write', 'user:edit'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['user:read', 'user:write', 'user:edit'])]
    private ?string $area = null;

    #[ORM\OneToOne(inversedBy: 'blog')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['user:read', 'user:write'])]
    private ?Plante $plante = null;

    #[ORM\ManyToOne(inversedBy: 'blogs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['user:read'])]
    private ?User $user_id = null;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    #[Groups(['user:read', 'user:write'])]
    private ?\DateTimeImmutable $update_at = null;

    #[ORM\Column]
    #[Groups(['user:read', 'user:write', 'user:read:plante', 'user:edit'])]
    private ?bool $isValidate = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function setArea(?string $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getPlante(): ?Plante
    {
        return $this->plante;
    }

    public function setPlante(Plante $plante): self
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTimeImmutable $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }

    public function isIsValidate(): ?bool
    {
        return $this->isValidate;
    }

    public function setIsValidate(bool $isValidate): self
    {
        $this->isValidate = $isValidate;

        return $this;
    }
}
