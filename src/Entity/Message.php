<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;
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
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get"={
 *      "normalization_context"={"groups"={"message:read", "message:item:get"}},
 *     },
 *      "put", "delete"},
 *     normalizationContext={"groups"={"message:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"message:write"}, "swagger_definition_name"="Write"},
 *     attributes={
 *     "pagination_items_per_page"=10
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={"subject": "partial", "messageAuthor": "partial", "messageRecipient": "partial"})
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"message:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"message:read", "message:write"})
     * @Assert\NotBlank()
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     * @Groups({"message:read", "message:write"})
     * @Assert\NotBlank()
     */
    private $text;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"message:read"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="writtenMessages")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"message:read", "message:write"})
     */
    private $messageAuthor;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="receivedMessages")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"message:read", "message:write"})
     */
    private $messageRecipient;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getMessageAuthor(): ?User
    {
        return $this->messageAuthor;
    }

    public function setMessageAuthor(?User $messageAuthor): self
    {
        $this->messageAuthor = $messageAuthor;

        return $this;
    }

    public function getMessageRecipient(): ?User
    {
        return $this->messageRecipient;
    }

    public function setMessageRecipient(?User $messageRecipient): self
    {
        $this->messageRecipient = $messageRecipient;

        return $this;
    }
}
