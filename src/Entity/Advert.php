<?php

namespace App\Entity;

use App\Repository\AdvertRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AdvertRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Advert
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Length(min="20")
     */
    private $title;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min="50")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class)
     */
    private $tags;

    /**
     * @ORM\OneToOne(targetEntity=PhotoGallery::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $gallery;

    /**
     * @ORM\Column(type="date")
     */
    private $year;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastUpdate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @ORM\PrePersist()
     */
    public function prePersist() {
        $this->creationDate = new \DateTime();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate() {
        $this->lastUpdate = new \DateTime();
    }

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    public function getGallery(): ?PhotoGallery
    {
        return $this->gallery;
    }

    public function setGallery(PhotoGallery $gallery): self
    {
        $this->gallery = $gallery;

        return $this;
    }

    public function getYear(): ?\DateTimeInterface
    {
        return $this->year;
    }

    public function setYear(\DateTimeInterface $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getLastUpdate(): ?\DateTimeInterface
    {
        return $this->lastUpdate;
    }

    public function setLastUpdate(?\DateTimeInterface $lastUpdate): self
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
