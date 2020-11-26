<?php

namespace App\Entity;

use App\Entity\Constants\FrameSize;
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

    use AuditableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Length(min="12")
     */
    private $title;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Choice(callback={"App\Entity\Constants\FrameSize", "values"}, message="Choose a valid size.")
     */
    private $frameSize;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fork;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Choice(callback={"App\Entity\Constants\Material", "values"}, message="Choose a valid material.")
     */
    private $material;

    /**
     * @ORM\Column(type="float")
     * @Assert\Choice(callback={"App\Entity\Constants\WheelSize", "values"}, message="Choose a valid size.")
    */
    private $wheelSize;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Choice(callback={"App\Entity\Constants\FrameType", "values"}, message="Choose a valid type.")
     */
    private $frameType;

    /**
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="advert")
     */
    private $questions;

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
        $this->questions = new ArrayCollection();
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

    public function getFrameSize(): ?string
    {
        return $this->frameSize;
    }

    public function setFrameSize(string $frameSize): self
    {
        $this->frameSize = $frameSize;

        return $this;
    }

    public function getFork(): ?string
    {
        return $this->fork;
    }

    public function setFork(?string $fork): self
    {
        $this->fork = $fork;

        return $this;
    }

    public function getMaterial(): ?string
    {
        return $this->material;
    }

    public function setMaterial(string $material): self
    {
        $this->material = $material;

        return $this;
    }

    public function getWheelSize(): ?int
    {
        return $this->wheelSize;
    }

    public function setWheelSize(int $wheelSize): self
    {
        $this->wheelSize = $wheelSize;

        return $this;
    }

    public function getFrameType(): ?string
    {
        return $this->frameType;
    }

    public function setFrameType(string $frameType): self
    {
        $this->frameType = $frameType;

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setAdvert($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getAdvert() === $this) {
                $question->setAdvert(null);
            }
        }

        return $this;
    }
}
