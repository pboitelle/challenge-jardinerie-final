<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DemandeBloggerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\CreateDemandeBloggerController;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\GetCollection;

use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DemandeBloggerRepository::class)]
#[ApiResource()]
#[GetCollection(
    uriTemplate: '/demande-bloggers',
    name: 'user_demande_bloggers',
    openapiContext: [
        'summary' => 'Récupère la liste des demandes pour devenir bloggers',
        'description' => 'Récupère la liste des demandes pour devenir bloggers',
    ],
    security: 'is_granted("ROLE_ADMIN")',
    paginationEnabled: false,
    denormalizationContext: ['groups' => 'user:read'],
    normalizationContext: [
        'groups' => ['user:read'],
        'openapi_definition_name' => 'Collection<user_demande_bloggers>',
        'skip_null_values' => true,
        'include_user_id' => true,
        'max_depth' => 1,
    ],
)]
#[Post(
    uriTemplate: '/demande-bloggers',
    name: 'user_demande_blogger',
    controller: CreateDemandeBloggerController::class,
    openapiContext: [
        'summary' => 'Crée une demande de blogger',
        'description' => 'Crée une demande de blogger',
    ],
    denormalizationContext: ['groups' => 'user:write'],
    security: 'is_granted("ROLE_USER")'
)]
#[Delete(
    uriTemplate: '/demande-bloggers/{id}',
    name: 'user_demande_blogger_delete',
    openapiContext: [
        'summary' => 'Supprime une demande pour devenir blogger',
        'description' => 'Supprime une demande pour devenir blogger',
    ],
    security: 'is_granted("ROLE_ADMIN")'
)]
class DemandeBlogger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    
    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['user:write', 'user:read'])]
    private ?string $motif = null;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['user:read'])]
    private ?User $user_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): self
    {
        $this->motif = $motif;

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

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
