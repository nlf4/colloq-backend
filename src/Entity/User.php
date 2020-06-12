<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use \Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 *     accessControl = "is_granted('ROLE_USER')",
 *     collectionOperations={"get"={
 *      "normalization_context"={"groups"={"user:read", "user:item:get"}},
 *     },
 *     "post"={
 *      "validation_groups"={"Default", "create"}
 *     }},
 *     itemOperations={"get", "put", "delete"},
 *     normalizationContext={"groups"={"user:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"user:write"}, "swagger_definition_name"="Write"},
 *     attributes={
 *     "pagination_items_per_page"=10
 *     }
 * )
 * @ApiFilter(BooleanFilter::class, properties={"isTutor", "isTourist"})
 * @ApiFilter(SearchFilter::class, properties={"firstname": "partial"})
// * @ApiFilter(SearchFilter::class, properties={"city": "exact"})
 * @ApiFilter(RangeFilter::class, properties={"age"})
 * @ApiFilter(SearchFilter::class, properties={
 *     "city.name": "exact"
 * })
 * @UniqueEntity(fields={"email"})
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user:read", "message:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write", "city:read"})
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email entered is not a valid email."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:write"})
     *
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user:read", "user:write", "message:read"})
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user:read", "user:write", "message:read"})
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $age;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @Groups({"user:read"})
     */
    private $roles = [];

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="localUsers")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="touristUsers")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $meetupCity;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank()
     */
    private $availStartDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank()
     */
    private $availEndDate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"user:read", "user:write"})
     *
     */
    private $isTourist;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $isTutor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank()
     */
    private $meetupType;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $publicMessage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user:write"})
     * @SerializedName("password")
     * @Assert\NotBlank(groups={"create"})
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="messageAuthor", orphanRemoval=true)
     */
    private $writtenMessages;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="messageRecipient", orphanRemoval=true)
     */
    private $receivedMessages;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="commentAuthor", orphanRemoval=true)
     */
    private $writtenComments;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="commentRecipient", orphanRemoval=true)
     */
    private $receivedComments;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="user", orphanRemoval=true)
     * @Groups({"user:read", "user:write"})
     */
    private $images;

    /**
     * @ORM\ManyToMany(targetEntity=Meetup::class, inversedBy="users")
     */
    private $meetups;

    /**
     * @ORM\OneToMany(targetEntity=UserLanguages::class, mappedBy="user")
     */
    private $userLanguages;

    public function __construct()
    {
        $this->roles[] = 'ROLE_USER';
        $this->writtenMessages = new ArrayCollection();
        $this->receivedMessages = new ArrayCollection();
        $this->writtenComments = new ArrayCollection();
        $this->receivedComments = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->meetups = new ArrayCollection();
        $this->userLanguages = new ArrayCollection();
    }

    public function __toString()
    {

        return (string)$this->getEmail();
    }

    public function getId(): ?int
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

    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFullName()
    {
        return $this->getFirstName().' '.$this->getLastName();
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername(): string
    {
        return (string) $this->email;
    }


    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getMeetupCity(): ?city
    {
        return $this->meetupCity;
    }

    public function setMeetupCity(?city $meetupCity): self
    {
        $this->meetupCity = $meetupCity;

        return $this;
    }

    public function getAvailStartDate(): ?\DateTimeInterface
    {
        return $this->availStartDate;
    }

    public function setAvailStartDate(\DateTimeInterface $availStartDate): self
    {
        $this->availStartDate = $availStartDate;

        return $this;
    }

    public function getAvailEndDate(): ?\DateTimeInterface
    {
        return $this->availEndDate;
    }

    public function setAvailEndDate(\DateTimeInterface $availEndDate): self
    {
        $this->availEndDate = $availEndDate;

        return $this;
    }

    public function getIsTourist(): ?bool
    {
        return $this->isTourist;
    }

    public function setIsTourist(bool $isTourist): self
    {
        $this->isTourist = $isTourist;

        return $this;
    }

    public function getIsTutor(): ?bool
    {
        return $this->isTutor;
    }

    public function setIsTutor(bool $isTutor): self
    {
        $this->isTutor = $isTutor;

        return $this;
    }

    public function getMeetupType(): ?string
    {
        return $this->meetupType;
    }

    public function setMeetupType(string $meetupType): self
    {
        $this->meetupType = $meetupType;

        return $this;
    }

    public function getPublicMessage(): ?string
    {
        return $this->publicMessage;
    }

    public function setPublicMessage(?string $publicMessage): self
    {
        $this->publicMessage = $publicMessage;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getWrittenMessages(): Collection
    {
        return $this->writtenMessages;
    }

    public function addWrittenMessage(Message $writtenMessage): self
    {
        if (!$this->writtenMessages->contains($writtenMessage)) {
            $this->writtenMessages[] = $writtenMessage;
            $writtenMessage->setMessageAuthor($this);
        }

        return $this;
    }

    public function removeWrittenMessage(Message $writtenMessage): self
    {
        if ($this->writtenMessages->contains($writtenMessage)) {
            $this->writtenMessages->removeElement($writtenMessage);
            // set the owning side to null (unless already changed)
            if ($writtenMessage->getMessageAuthor() === $this) {
                $writtenMessage->setMessageAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getReceivedMessages(): Collection
    {
        return $this->receivedMessages;
    }

    public function addReceivedMessage(Message $receivedMessage): self
    {
        if (!$this->receivedMessages->contains($receivedMessage)) {
            $this->receivedMessages[] = $receivedMessage;
            $receivedMessage->setMessageRecipient($this);
        }

        return $this;
    }

    public function removeReceivedMessage(Message $receivedMessage): self
    {
        if ($this->receivedMessages->contains($receivedMessage)) {
            $this->receivedMessages->removeElement($receivedMessage);
            // set the owning side to null (unless already changed)
            if ($receivedMessage->getMessageRecipient() === $this) {
                $receivedMessage->setMessageRecipient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getWrittenComments(): Collection
    {
        return $this->writtenComments;
    }

    public function addWrittenComment(Comment $writtenComment): self
    {
        if (!$this->writtenComments->contains($writtenComment)) {
            $this->writtenComments[] = $writtenComment;
            $writtenComment->setCommentAuthor($this);
        }

        return $this;
    }

    public function removeWrittenComment(Comment $writtenComment): self
    {
        if ($this->writtenComments->contains($writtenComment)) {
            $this->writtenComments->removeElement($writtenComment);
            // set the owning side to null (unless already changed)
            if ($writtenComment->getCommentAuthor() === $this) {
                $writtenComment->setCommentAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getReceivedComments(): Collection
    {
        return $this->receivedComments;
    }

    public function addReceivedComment(Comment $receivedComment): self
    {
        if (!$this->receivedComments->contains($receivedComment)) {
            $this->receivedComments[] = $receivedComment;
            $receivedComment->setCommentRecipient($this);
        }

        return $this;
    }

    public function removeReceivedComment(Comment $receivedComment): self
    {
        if ($this->receivedComments->contains($receivedComment)) {
            $this->receivedComments->removeElement($receivedComment);
            // set the owning side to null (unless already changed)
            if ($receivedComment->getCommentRecipient() === $this) {
                $receivedComment->setCommentRecipient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setUser($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getUser() === $this) {
                $image->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Meetup[]
     */
    public function getMeetups(): Collection
    {
        return $this->meetups;
    }

    public function addMeetup(Meetup $meetup): self
    {
        if (!$this->meetups->contains($meetup)) {
            $this->meetups[] = $meetup;
        }

        return $this;
    }

    public function removeMeetup(Meetup $meetup): self
    {
        if ($this->meetups->contains($meetup)) {
            $this->meetups->removeElement($meetup);
        }

        return $this;
    }

    /**
     * @return Collection|UserLanguages[]
     */
    public function getUserLanguages(): Collection
    {
        return $this->userLanguages;
    }

    public function addUserLanguage(UserLanguages $userLanguage): self
    {
        if (!$this->userLanguages->contains($userLanguage)) {
            $this->userLanguages[] = $userLanguage;
            $userLanguage->setUser($this);
        }

        return $this;
    }

    public function removeUserLanguage(UserLanguages $userLanguage): self
    {
        if ($this->userLanguages->contains($userLanguage)) {
            $this->userLanguages->removeElement($userLanguage);
            // set the owning side to null (unless already changed)
            if ($userLanguage->getUser() === $this) {
                $userLanguage->setUser(null);
            }
        }

        return $this;
    }
}
