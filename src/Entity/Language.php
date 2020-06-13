<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *      itemOperations={"get", "put", "delete"},
 *     normalizationContext={"groups"={"language:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"language:write"}, "swagger_definition_name"="Write"}
 * )
 * @ApiFilter(SearchFilter::class, properties={"name": "exact"})
 * @ORM\Entity(repositoryClass=LanguageRepository::class)
 */
class Language
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"language:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"language:read"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Meetup::class, mappedBy="language")
     * @Groups({"language:read"})
     */
    private $meetups;

    /**
     * @ORM\OneToMany(targetEntity=UserLanguages::class, mappedBy="language")
     * @Groups({"language:read"})
     */
    private $userLanguages;

    public function __construct()
    {
        $this->meetups = new ArrayCollection();
        $this->userLanguages = new ArrayCollection();
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
            $meetup->setLanguage($this);
        }

        return $this;
    }

    public function removeMeetup(Meetup $meetup): self
    {
        if ($this->meetups->contains($meetup)) {
            $this->meetups->removeElement($meetup);
            // set the owning side to null (unless already changed)
            if ($meetup->getLanguage() === $this) {
                $meetup->setLanguage(null);
            }
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
            $userLanguage->setLanguage($this);
        }

        return $this;
    }

    public function removeUserLanguage(UserLanguages $userLanguage): self
    {
        if ($this->userLanguages->contains($userLanguage)) {
            $this->userLanguages->removeElement($userLanguage);
            // set the owning side to null (unless already changed)
            if ($userLanguage->getLanguage() === $this) {
                $userLanguage->setLanguage(null);
            }
        }

        return $this;
    }
}
