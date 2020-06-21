<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;

/**
 * @ApiResource(
 *     collectionOperations={"get"={
 *     "normalization_context"={"groups"={"city:read", "city:item:get"}},
 *     }, "post"},
 *      itemOperations={"get"={
 *     "normalization_context"={"groups"={"city:read", "city:item:get"}},
 *     }, "put", "delete"},
 *     normalizationContext={"groups"={"city:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"city:write"}, "swagger_definition_name"="Write"}
 * )
 * @ApiFilter(PropertyFilter::class)
 * @ApiFilter(SearchFilter::class, properties={"name": "exact"})
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */
class City
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"city:read", "user:item:get", "user:read", "user:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"city:read", "city:write", "user:item:get", "user:read", "user:write", "country:read"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="cities", cascade={"persist"}))
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"city:read"})
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="city")
     * @Groups({"city:read", "city:write", "user:write"})
     */
    private $localUsers;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="meetupCity")
     * @Groups({"city:read", "city:write", "user:write"})
     */
    private $touristUsers;

    /**
     * @ORM\OneToMany(targetEntity=Meetup::class, mappedBy="city")
     */
    private $meetups;

    public function __construct()
    {
        $this->localUsers = new ArrayCollection();
        $this->touristUsers = new ArrayCollection();
        $this->meetups = new ArrayCollection();
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

    public function getCountry(): ?country
    {
        return $this->country;
    }

    public function setCountry(?country $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getLocalUsers(): Collection
    {
        return $this->localUsers;
    }

    public function addLocalUser(User $localUser): self
    {
        if (!$this->localUsers->contains($localUser)) {
            $this->localUsers[] = $localUser;
            $localUser->setMeetupCity($this);
        }

        return $this;
    }

    public function removeLocalUser(User $localUser): self
    {
        if ($this->localUsers->contains($localUser)) {
            $this->localUsers->removeElement($localUser);
            // set the owning side to null (unless already changed)
            if ($localUser->getMeetupCity() === $this) {
                $localUser->setMeetupCity(null);
            }
        }

        return $this;
    }

    public function getTouristUsers(): Collection
    {
        return $this->touristUsers;
    }

    public function addTouristUser(User $touristUser): self
    {
        if (!$this->touristUsers->contains($touristUser)) {
            $this->touristUsers[] = $touristUser;
            $touristUser->setMeetupCity($this);
        }

        return $this;
    }

    public function removeTouristUser(User $touristUser): self
    {
        if ($this->touristUsers->contains($touristUser)) {
            $this->touristUsers->removeElement($touristUser);
            // set the owning side to null (unless already changed)
            if ($touristUser->getMeetupCity() === $this) {
                $touristUser->setMeetupCity(null);
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
            $meetup->setCity($this);
        }

        return $this;
    }

    public function removeMeetup(Meetup $meetup): self
    {
        if ($this->meetups->contains($meetup)) {
            $this->meetups->removeElement($meetup);
            // set the owning side to null (unless already changed)
            if ($meetup->getCity() === $this) {
                $meetup->setCity(null);
            }
        }

        return $this;
    }
}
