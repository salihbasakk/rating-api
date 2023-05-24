<?php

namespace App\Entity;

use App\Repository\FeedbackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: FeedbackRepository::class)]
class Feedback extends BaseEntity implements JsonSerializable
{
    #[ORM\Column(length: 255)]
    private ?string $comment = null;

    #[ORM\Column(nullable: true)]
    private ?float $overallRating = null;

    #[ORM\ManyToOne(inversedBy: 'feedback')]
    #[ORM\JoinColumn(name:'project', referencedColumnName: 'id')]
    private ?Project $project = null;

    #[ORM\ManyToOne(inversedBy: 'feedback')]
    #[ORM\JoinColumn(name:'client', referencedColumnName: 'id')]
    private ?Client $client = null;

    #[ORM\OneToMany(mappedBy: 'feedback', targetEntity: Rating::class)]
    private Collection $ratings;

    public function __construct()
    {
        $this->ratings = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     * @return Feedback
     */
    public function setComment(?string $comment): Feedback
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getOverallRating(): ?float
    {
        return $this->overallRating;
    }

    /**
     * @param float|null $overallRating
     * @return Feedback
     */
    public function setOverallRating(?float $overallRating): Feedback
    {
        $this->overallRating = $overallRating;
        return $this;
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
     * @return Feedback
     */
    public function setProject(?Project $project): Feedback
    {
        $this->project = $project;
        return $this;
    }

    /**
     * @return Client|null
     */
    public function getClient(): ?Client
    {
        return $this->client;
    }

    /**
     * @param Client|null $client
     * @return Feedback
     */
    public function setClient(?Client $client): Feedback
    {
        $this->client = $client;
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
            $rating->setFeedback($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            if ($rating->getFeedback() === $this) {
                $rating->setFeedback(null);
            }
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'comment' => $this->getComment(),
            'overallRating' => $this->getOverallRating(),
            'project' => $this->getProject()->getId(),
            'client' => $this->getClient()->getId(),
        ];
    }
}
