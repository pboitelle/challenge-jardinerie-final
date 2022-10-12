<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\HackathonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Unique;

#[ApiResource(
    normalizationContext: ['groups' => ['hackathon_read']],
    denormalizationContext: ['groups' => ['hackathon_write']]
)]
#[Get(
    normalizationContext: ['groups' => ['hackathon_get', 'hackathon_read']],
    security: 'is_granted("ROLE_COACH") or is_granted("HACKATHON_GET", object)' // VOTER
)]
//security: 'is_granted("ROLE_COACH") or object.getParticipants().contains(user)' BEST METHOD
#[GetCollection(
    normalizationContext: ['groups' => ['hackathon_cget', 'hackathon_read']],
    security: 'is_granted("ROLE_COACH")'
)]
#[Post(
    security: 'is_granted("ROLE_USER")'
)]
#[Patch(
    security: 'is_granted("ROLE_ADMIN") or object.getOwner() == user'
)]
#[Delete(
    security: 'is_granted("ROLE_ADMIN") or object.getOwner() == user'
)]
#[ORM\Entity(repositoryClass: HackathonRepository::class)]
#[UniqueEntity('name')]
class Hackathon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['hackathon_read', 'hackathon_write'])]
    #[NotBlank(message: 'test')]
    #[Length(max: 255)]
    #[Type('string')]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['hackathon_get', 'hackathon_write'])]
    private ?string $clientName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['hackathon_get', 'hackathon_write'])]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['hackathon_get', 'hackathon_write'])]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\OneToMany(mappedBy: 'hackathon', targetEntity: Document::class)]
    #[Groups('hackathon_get')]
    private Collection $documents;

    #[ORM\OneToMany(mappedBy: 'hackathon', targetEntity: Groupe::class)]
    #[Groups('hackathon_get')]
    private Collection $groupes;

    #[ORM\OneToMany(mappedBy: 'hackathon', targetEntity: Event::class)]
    private Collection $events;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'hackathons')]
    #[Unique]
    private Collection $participants;

    #[ORM\ManyToOne]
    #[Blameable(on: 'create')]
    private ?User $owner = null;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function setClientName(?string $clientName): self
    {
        $this->clientName = $clientName;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setHackathon($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getHackathon() === $this) {
                $document->setHackathon(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Groupe>
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->setHackathon($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getHackathon() === $this) {
                $groupe->setHackathon(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setHackathon($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getHackathon() === $this) {
                $event->setHackathon(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(User $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
        }

        return $this;
    }

    public function removeParticipant(User $participant): self
    {
        $this->participants->removeElement($participant);

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
