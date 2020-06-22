<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MeetupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *      itemOperations={"get", "put", "delete"},
 * )
 *
 * @ApiResource(attributes={
 *  "force_eager"=true,
 *  "normalization_context"={"groups"={"meetup:read"},"enable_max_depth"=true},
 *  "denormalization_context"={"groups"={"meetup:write"},"enable_max_depth"=true}
 *     })
 *
 * @ApiFilter(SearchFilter::class, properties={
 *     "users": "exact"
 * })
 * @ApiFilter(SearchFilter::class, properties={
 *     "creator": "exact"
 * })
 * @ORM\Entity(repositoryClass=MeetupRepository::class)
 */
class Meetup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"meetup:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"meetup:read", "meetup:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="date")
     * @Groups({"meetup:read", "meetup:write"})
     */
    private $date;

    /**
     * @ORM\Column(type="time")
     * @Groups({"meetup:read", "meetup:write"})
     */
    private $startTime;

    /**
     * @ORM\Column(type="time")
     * @Groups({"meetup:read", "meetup:write"})
     */
    private $endTime;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"meetup:read", "meetup:write"})
     */
    private $type;

    /**
     * @ORM\Column(type="text")
     * @Groups({"meetup:read", "meetup:write"})
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="meetups")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"meetup:read", "meetup:write"})
     * @MaxDepth(1)
     */
    private $city;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="meetups")
     * @Groups({"meetup:read", "meetup:write"})
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=Language::class, inversedBy="meetups")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"meetup:read", "meetup:write"})
     * @MaxDepth(1)
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="createdMeetups")
     * @Groups({"meetup:read", "meetup:write"})
     * @MaxDepth(1)
     */
    private $creator;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="participatingMeetups")
     * @Groups({"meetup:read", "meetup:write"})
     * @MaxDepth(1)
     */
    private $participant;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function __toString()
    {

        return (string)$this->getName();
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getCity(): ?city
    {
        return $this->city;
    }

    public function setCity(?city $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addMeetup($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeMeetup($this);
        }

        return $this;
    }

    public function getLanguage(): ?language
    {
        return $this->language;
    }

    public function setLanguage(?language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getCreator(): ?user
    {
        return $this->creator;
    }

    public function setCreator(?user $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function getParticipant(): ?user
    {
        return $this->participant;
    }

    public function setParticipant(?user $participant): self
    {
        $this->participant = $participant;

        return $this;
    }
}
