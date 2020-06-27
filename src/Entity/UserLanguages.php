<?php

namespace App\Entity;

use App\Repository\UserLanguagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserLanguagesRepository::class)
 */
class UserLanguages
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isNative;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isTarget;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userLanguages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Language::class, inversedBy="userLanguages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $language;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsNative(): ?bool
    {
        return $this->isNative;
    }

    public function setIsNative(?bool $isNative): self
    {
        $this->isNative = $isNative;

        return $this;
    }

    public function getIsTarget(): ?bool
    {
        return $this->isTarget;
    }

    public function setIsTarget(?bool $isTarget): self
    {
        $this->isTarget = $isTarget;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

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
}
