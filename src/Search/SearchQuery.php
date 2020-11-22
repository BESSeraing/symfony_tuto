<?php


namespace App\Search;


use App\Entity\Category;
use App\Entity\Constants\FrameType;
use App\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;

class SearchQuery
{

    private string $keyword;

    /**
     * @var Category
     */
    private Category $category;


    /**
     * @var Tag[]
     */
    private array $tags;

    private string $frameType;

    private string $frameSize;

    private int $priceMin;

    private int $priceMax;

    /**
     * @return string
     */
    public function getKeyword(): string
    {
        return $this->keyword;
    }

    /**
     * @param string $keyword
     */
    public function setKeyword(string $keyword): void
    {
        $this->keyword = $keyword;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return Tag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param Tag[] $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return string
     */
    public function getFrameType(): string
    {
        return $this->frameType;
    }

    /**
     * @param string $frameType
     */
    public function setFrameType(string $frameType): void
    {
        $this->frameType = $frameType;
    }

    /**
     * @return string
     */
    public function getFrameSize(): string
    {
        return $this->frameSize;
    }

    /**
     * @param string $frameSize
     */
    public function setFrameSize(string $frameSize): void
    {
        $this->frameSize = $frameSize;
    }

    /**
     * @return int
     */
    public function getPriceMin(): int
    {
        return $this->priceMin;
    }

    /**
     * @param int $priceMin
     */
    public function setPriceMin(int $priceMin): void
    {
        $this->priceMin = $priceMin;
    }

    /**
     * @return int
     */
    public function getPriceMax(): int
    {
        return $this->priceMax;
    }

    /**
     * @param int $priceMax
     */
    public function setPriceMax(int $priceMax): void
    {
        $this->priceMax = $priceMax;
    }



}
