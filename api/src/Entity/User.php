<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\GetCollection;

use App\Controller\ResetPasswordController;
use App\Controller\ChangePasswordController;
use App\Controller\MailAchatCoinsController;
use App\Controller\UpdateRoleController;
use App\Controller\UpdateCreditCoinsController;
use App\Controller\UpdateDebitCoinsController;
use App\Controller\GetBlogsController;
use App\Controller\GetItemsController;
use App\Controller\GetItemsMarketController;
use App\Controller\GetVentesController;
use App\Controller\GetAchatsController;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\MeController;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(
    operations: [
        new Get(
            paginationEnabled: false,
            uriTemplate: '/users/me',
            controller: MeController::class,
            read: false,
            name: 'me',
        ),
        new Post(
            uriTemplate: '/users/reset-password',
            controller: ResetPasswordController::class,
            name: 'reset-password',
            denormalizationContext: ['groups' => 'reset-password'],
        ),
        new Post(
            uriTemplate: '/users/change-password',
            controller: ChangePasswordController::class,
            name: 'change-password',
            denormalizationContext: ['groups' => 'change-password']
        ),
        new Patch(
            uriTemplate: '/users/achat-coins/{id}/{coins}',
            controller: MailAchatCoinsController::class,
            name: 'user_achat_coins',
            denormalizationContext: ['groups' => 'achat-coins'],
            read: false,
        ),
        new Patch(
            uriTemplate: '/users/{id}/role',
            controller: UpdateRoleController::class,
            name: 'user_role_edit',
            denormalizationContext: ['groups' => 'user:role'],
            read: false,
            security: 'is_granted("ROLE_ADMIN")',
        ),
        new Patch(
            uriTemplate: '/users/{id}/credit-coins',
            controller: UpdateCreditCoinsController::class,
            name: 'user_credit_coins_edit',
            denormalizationContext: ['groups' => 'user:coin'],
            read: false,
            security: 'is_granted("ROLE_USER") and id == user.getId()',
        ),
        new Patch(
            uriTemplate: '/users/{id}/debit-coins',
            controller: UpdateDebitCoinsController::class,
            name: 'user_debit_coins_edit',
            denormalizationContext: ['groups' => 'user:coin'],
            read: false,
            security: 'is_granted("ROLE_USER")',
        ),
        new GetCollection(
            paginationEnabled: false,
            uriTemplate: '/users/{id}/blogs',
            controller: GetBlogsController::class,
            read: false,
            name: 'get_blogs',
            openapiContext: [
                'summary' => 'Récupère les blogs d\'un utilisateur',
                'description' => 'Récupère les blogs d\'un utilisateur',
            ],
            normalizationContext: [
                'groups' => ['user:read', 'user:read:plante'],
                'openapi_definition_name' => 'Detail<plantes>',
                'skip_null_values' => true,
                'include_user_id' => true,
                'max_depth' => 1,
            ],
            security: 'is_granted("ROLE_BLOGER") and id == user.getId()',
        ),
        new GetCollection(
            paginationEnabled: false,
            uriTemplate: '/users/{id}/items',
            controller: GetItemsController::class,
            read: false,
            name: 'get_items',
            openapiContext: [
                'summary' => 'Récupère les items d\'un utilisateur',
                'description' => 'Récupère les items d\'un utilisateur',
            ],
            normalizationContext: [
                'groups' => ['item:read'],
                'openapi_definition_name' => 'Detail<plantes>',
                'skip_null_values' => false,
                'include_user_id' => true,
                'max_depth' => 1,
            ],
            security: 'is_granted("ROLE_USER") and id == user.getId()',
        ),
        new GetCollection(
            paginationEnabled: false,
            uriTemplate: '/users/{id}/markets',
            controller: GetItemsMarketController::class,
            read: false,
            name: 'get_items_market',
            openapiContext: [
                'summary' => 'Récupère les items d\'un utilisateur en ventes',
                'description' => 'Récupère les items d\'un utilisateur en ventes',
            ],
            normalizationContext: [
                'groups' => ['item:read'],
                'openapi_definition_name' => 'Detail<plantes>',
                'skip_null_values' => true,
                'include_user_id' => true,
                'max_depth' => 1,
            ],
            security: 'is_granted("ROLE_USER") and id == user.getId()',
        ),
        new GetCollection(
            paginationEnabled: false,
            uriTemplate: '/users/{id}/ventes',
            controller: GetVentesController::class,
            read: false,
            name: 'get_ventes',
            openapiContext: [
                'summary' => 'Récupère les ventes d\'un utilisateur',
                'description' => 'Récupère les ventes d\'un utilisateur',
            ],
            denormalizationContext: ['groups' => ['user:vente:read']],
            normalizationContext: [
                'groups' => ['user:vente:read'],
                'openapi_definition_name' => 'Detail<plantes>',
                'skip_null_values' => true,
                'include_user_id' => true,
                'max_depth' => 1,
            ],
            security: 'is_granted("ROLE_USER") and id == user.getId()',
        ),
        new GetCollection(
            paginationEnabled: false,
            uriTemplate: '/users/{id}/achats',
            controller: GetAchatsController::class,
            read: false,
            name: 'get_achats',
            openapiContext: [
                'summary' => 'Récupère les ventes d\'un utilisateur',
                'description' => 'Récupère les ventes d\'un utilisateur',
            ],
            denormalizationContext: ['groups' => ['user:vente:read']],
            normalizationContext: [
                'groups' => ['user:vente:read'],
                'openapi_definition_name' => 'Detail<plantes>',
                'skip_null_values' => true,
                'include_user_id' => true,
                'max_depth' => 1,
            ],
            security: 'is_granted("ROLE_USER") and id == user.getId()',
        ),
    ],
    normalizationContext: ['groups' => ['user:read']],
)]
#[Post()]
#[Get()]
#[Patch()]
#[Put(
    uriTemplate: '/users/{id}',
    name: 'user_put',
    openapiContext: [
        'summary' => 'Modifier un utilisateur',
        'description' => 'Modifie un utilisateur',
    ],
    denormalizationContext: ['groups' => 'user:write'],
    security: 'is_granted("ROLE_ADMIN")',
)]
#[Delete(
    uriTemplate: '/users/{id}',
    name: 'user_delete',
    openapiContext: [
        'summary' => 'Supprimer un utilisateur',
        'description' => 'Supprime un utilisateur',
    ],
    security: 'is_granted("ROLE_ADMIN")',
)]
#[GetCollection(
    paginationEnabled: false,
    uriTemplate: '/users',
    name: 'user_list',
    openapiContext: [
        'summary' => 'Liste des utilisateurs',
        'description' => 'Retourne la liste des utilisateurs',
    ],
    security: 'is_granted("ROLE_ADMIN")',
)]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups(['user:read', 'market:read', 'item:write', 'user:vente:read'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['user:read', 'user:write', 'reset-password'])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['user:read', 'user:role'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['change-password'])]
    private ?string $password = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['change-password'])]
    private ?string $token = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'user:write', 'market:read', 'user:vente:read'])]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'user:write', 'market:read', 'user:vente:read'])]
    private ?string $firstname = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['user:read', 'achat-coins', 'user:coin'])]
    private ?int $nb_coins = null;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Item::class)]
    private Collection $items;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Blog::class, orphanRemoval: true)]
    private Collection $blogs;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Market::class, orphanRemoval: true)]
    private Collection $markets;

    #[ORM\OneToMany(mappedBy: 'vendeur', targetEntity: Vente::class, orphanRemoval: true)]
    #[Groups(['vente:write', 'vente:read'])]
    private Collection $ventes;

    #[ORM\OneToMany(mappedBy: 'acheteur', targetEntity: Vente::class, orphanRemoval: true)]
    private Collection $achats;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->blogs = new ArrayCollection();
        $this->markets = new ArrayCollection();
        $this->ventes = new ArrayCollection();
        $this->achats = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getNbCoins(): ?int
    {
        return $this->nb_coins;
    }

    public function setNbCoins(?int $nb_coins): self
    {
        $this->nb_coins = $nb_coins;

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setUserId($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getUserId() === $this) {
                $item->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Blog>
     */
    public function getBlogs(): Collection
    {
        return $this->blogs;
    }

    public function addBlog(Blog $blog): self
    {
        if (!$this->blogs->contains($blog)) {
            $this->blogs->add($blog);
            $blog->setUserId($this);
        }

        return $this;
    }

    public function removeBlog(Blog $blog): self
    {
        if ($this->blogs->removeElement($blog)) {
            // set the owning side to null (unless already changed)
            if ($blog->getUserId() === $this) {
                $blog->setUserId(null);
            }
        }
        
        return $this;
    }

    /**
     * @return Collection<int, Market>
     */
    public function getMarkets(): Collection
    {
        return $this->markets;
    }

    public function addMarket(Market $market): self
    {
        if (!$this->markets->contains($market)) {
            $this->markets->add($market);
            $market->setUserId($this);
        }

        return $this;
    }

    public function removeMarket(Market $market): self
    {
        if ($this->markets->removeElement($market)) {
            // set the owning side to null (unless already changed)
            if ($market->getUserId() === $this) {
                $market->setUserId(null);
            }
        }

       return $this;
    }

    /**
     * @return Collection<int, Vente>
     */
    public function getVentes(): Collection
    {
        return $this->ventes;
    }



    /**
     * @return Collection<int, Vente>
     */
    public function getAchats(): Collection
    {
        return $this->achats;
    }
}