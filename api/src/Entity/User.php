<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use App\Controller\ResetPasswordController;
use App\Controller\ChangePasswordController;
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
    // security: 'is_granted("ROLE_USER")',
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
        new Patch(
            uriTemplate: '/users/change-password/{id}',
            controller: ChangePasswordController::class,
            name: 'change-password',
            denormalizationContext: ['groups' => 'change-password']
        ),
    ],
    normalizationContext: ['groups' => ['user:read']],
)]
#[Post()]
#[Get()]
#[Patch()]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups(['user:read'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['user:read', 'reset-password'])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['change-password'])]
    private ?string $password = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $token = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read'])]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read'])]
    private ?string $firstname = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_coins = null;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Item::class)]
    private Collection $items;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Blog::class, orphanRemoval: true)]
    private Collection $blogs;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Market::class, orphanRemoval: true)]
    private Collection $markets;

    #[ORM\OneToMany(mappedBy: 'vendeur', targetEntity: Vente::class, orphanRemoval: true)]
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