<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get"={
 *      "normalization_context"={"groups"={"comment:read", "comment:item:get"}},
 *     },
 *      "put", "delete"},
 *     normalizationContext={"groups"={"comment:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"comment:write"}, "swagger_definition_name"="Write"},
 *     attributes={
 *     "pagination_items_per_page"=10
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={"commentAuthor": "partial", "commentRecipient": "partial"})
 * @ApiFilter(DateFilter::class, properties={"createdAt"})
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"comment:read", "comment:write"})
     * @Assert\NotBlank()
     */
    private $text;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"comment:read"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="writtenComments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"comment:read"})
     */
    private $commentAuthor;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="receivedComments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"comment:read"})
     */
    private $commentRecipient;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCommentAuthor(): ?User
    {
        return $this->commentAuthor;
    }

    public function setCommentAuthor(?User $commentAuthor): self
    {
        $this->commentAuthor = $commentAuthor;

        return $this;
    }

    public function getCommentRecipient(): ?User
    {
        return $this->commentRecipient;
    }

    public function setCommentRecipient(?User $commentRecipient): self
    {
        $this->commentRecipient = $commentRecipient;

        return $this;
    }
}
