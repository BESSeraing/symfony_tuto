<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
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
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Advert::class, inversedBy="questions")
     */
    private $advert;

    /**
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="question")
     */
    private PersistentCollection $answers;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAdvert(): ?Advert
    {
        return $this->advert;
    }

    public function setAdvert(?Advert $advert): self
    {
        $this->advert = $advert;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param mixed $answers
     */
    public function setAnswers($answers): void
    {
        $this->answers = $answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!in_array($answer, $this->answers->getValues())) {
            $this->answers->add($answer);
            $answer->setQuestion($this);
        }
        return $this;
    }

    public function __toString()
    {
        return "".$this->getId();
    }


}
