<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * @ApiResource(
 *     iri="http://schema.org/Image",
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get"={
 *      "normalization_context"={"groups"={"image:read", "image:item:get"}},
 *     },
 *      "put", "delete"},
 *     normalizationContext={"groups"={"image:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"image:write"}, "swagger_definition_name"="Write"},
 *     attributes={
 *     "pagination_items_per_page"=10
 *
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={"filename": "partial", "title": "partial", "user": "partial"})
 * @ApiFilter(DateFilter::class, properties={"createdAt"})
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 * @Vich\Uploadable
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"image:read", "image:write", "user:read", "user:write"})
     */
    private $filename;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"image:read", "image:write"})
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"image:read", "image:write"})
     */
    private $caption;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     * @Groups({"image:read"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"image:read"})
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     * @Groups({"image:read", "image:write", "user:read", "user:write"})
     *
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="profile_photos", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

//    /**
//     * @var MediaObject|null
//     *
//     * @ORM\ManyToOne(targetEntity=MediaObject::class)
//     * @ORM\JoinColumn(nullable=true)
//     * @ApiProperty(iri="http://schema.org/vichImage")
//     */
//    public $vichImage;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function setCaption(?string $caption): self
    {
        $this->caption = $caption;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->createdAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

//    /**
//     * @return MediaObject|null
//     */
//    public function getVichImage(): ?MediaObject
//    {
//        return $this->vichImage;
//    }
//
//    /**
//     * @param MediaObject|null $vichImage
//     */
//    public function setVichImage(?MediaObject $vichImage): void
//    {
//        $this->vichImage = $vichImage;
//    }
}
