<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: RatingRepository::class)]
class Rating extends BaseEntity implements JsonSerializable
{
    #[ORM\ManyToOne(inversedBy: 'ratings')]
    #[ORM\JoinColumn(name:'feedback', referencedColumnName: 'id')]
    private ?Feedback $feedback = null;

    #[ORM\ManyToOne(inversedBy: 'ratings')]
    #[ORM\JoinColumn(name:'rating_question', referencedColumnName: 'id')]
    private ?RatingQuestion $ratingQuestion = null;

    #[ORM\Column]
    private ?float $score = null;

    /**
     * @return Feedback|null
     */
    public function getFeedback(): ?Feedback
    {
        return $this->feedback;
    }

    /**
     * @param Feedback|null $feedback
     * @return Rating
     */
    public function setFeedback(?Feedback $feedback): Rating
    {
        $this->feedback = $feedback;
        return $this;
    }

    /**
     * @return RatingQuestion|null
     */
    public function getRatingQuestion(): ?RatingQuestion
    {
        return $this->ratingQuestion;
    }

    /**
     * @param RatingQuestion|null $ratingQuestion
     * @return Rating
     */
    public function setRatingQuestion(?RatingQuestion $ratingQuestion): Rating
    {
        $this->ratingQuestion = $ratingQuestion;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getScore(): ?float
    {
        return $this->score;
    }

    /**
     * @param float|null $score
     * @return Rating
     */
    public function setScore(?float $score): Rating
    {
        $this->score = $score;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'feedback' => $this->getFeedback(),
            'ratingQuestion' => $this->getRatingQuestion(),
            'score' => $this->getScore(),
            'createdAt' => $this->getCreatedAt()
        ];
    }

}
