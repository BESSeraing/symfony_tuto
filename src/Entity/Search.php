<?php

namespace App\Entity;

use App\Repository\SearchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SearchRepository::class)
 * @inheritDoc j'en ai fait une entité comme ça un utilisateur peut sauvegarder sa recherche.
 */
class Search
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $keyword;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class)
     */
    private $tags;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priceMin;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priceMax;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class)
     */
    private $categories;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Assert\All({
     *     @Assert\Choice(callback={"App\Entity\Constants\FrameSize", "values"}, message="Choose a valid size.")
     * })
     */
    private $frameSizes = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Assert\All({
     *     @Assert\Choice(callback={"App\Entity\Constants\FrameType", "values"}, message="Choose a valid type.")
     * })
     */
    private $frameTypes = [];

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKeyword(): ?string
    {
        return $this->keyword;
    }

    public function setKeyword(string $keyword): self
    {
        $this->keyword = $keyword;

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

    public function getPriceMin(): ?int
    {
        return $this->priceMin;
    }

    public function setPriceMin(?int $priceMin): self
    {
        $this->priceMin = $priceMin;

        return $this;
    }

    public function getPriceMax(): ?int
    {
        return $this->priceMax;
    }

    public function setPriceMax(?int $priceMax): self
    {
        $this->priceMax = $priceMax;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    public function getFrameSizes(): ?array
    {
        return $this->frameSizes;
    }

    public function setFrameSizes(?array $frameSizes): self
    {
        $this->frameSizes = $frameSizes;

        return $this;
    }

    public function getFrameTypes(): ?array
    {
        return $this->frameTypes;
    }

    public function setFrameTypes(?array $frameTypes): self
    {
        $this->frameTypes = $frameTypes;

        return $this;
    }
}
