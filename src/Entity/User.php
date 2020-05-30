<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use \Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $roles = array();

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=true)
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=true)
     */
    private $meetupCity;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $availStartDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $availEndDate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isTourist;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isTutor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $meetupType;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $publicMessage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $plainPassword;

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
}
