<?php

namespace App\Entity;

use App\Repository\RatingQuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RatingQuestionRepository::class)]
class RatingQuestion extends BaseEntity implements \JsonSerializable
{
    #[ORM\OneToMany(mappedBy: 'ratingQuestion', targetEntity: Rating::class)]
    private Collection $ratings;

    #[ORM\ManyToOne(inversedBy: 'ratingQuestions')]
    #[ORM\JoinColumn(name:'project', referencedColumnName: 'id')]
    private ?Project $project = null;

    #[ORM\Column(length: 255)]
    private ?string $question = null;

    public function __construct()
    {
        $this->ratings = new ArrayCollection();
    }

    /**
     * @return Project|null
     */
    public function getProject(): ?Project
    {
        return $this->project;
    }

    /**
     * @param Project|null $project
     * @return RatingQuestion
     */
    public function setProject(?Project $project): RatingQuestion
    {
        $this->project = $project;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getQuestion(): ?string
    {
        return $this->question;
    }

    /**
     * @param string|null $question
     * @return RatingQuestion
     */
    public function setQuestion(?string $question): RatingQuestion
    {
        $this->question = $question;
        return $this;
    }

    /**
     * @return Collection<int, Rating>
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings->add($rating);
            $rating->setRatingQuestion($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            if ($rating->getRatingQuestion() === $this) {
                $rating->setRatingQuestion(null);
            }
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'project' => $this->getProject()->getId(),
            'question' => $this->getQuestion(),
        ];
    }
}
