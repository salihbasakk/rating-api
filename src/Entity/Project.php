<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use JsonSerializable;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[Index(columns: ['vico_id'], name: 'IDX_2FB3D0EE19F89217')]
#[Index(columns: ['creator_id'], name: 'creator_idx')]
#[Index(columns: ['created_at'], name: 'created_at_idx')]
class Project extends BaseEntity implements JsonSerializable
{
    #[ORM\Column(name: 'title', length: 255, nullable: false)]
    private string $title;

    #[ORM\ManyToOne(targetEntity: Vico::class)]
    #[ORM\JoinColumn(name:'vico_id', referencedColumnName: 'id')]
    private Vico $vico;

    #[ORM\ManyToOne(targetEntity: Client::class)]
    #[ORM\JoinColumn(name:'creator_id', referencedColumnName: 'id')]
    private Client $creator;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: RatingQuestion::class)]
    private Collection $ratingQuestions;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Feedback::class)]
    private Collection $feedback;

    public function __construct()
    {
        $this->ratingQuestions = new ArrayCollection();
        $this->feedback = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Project
     */
    public function setTitle(string $title): Project
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return Vico
     */
    public function getVico(): Vico
    {
        return $this->vico;
    }

    /**
     * @param Vico $vico
     * @return Project
     */
    public function setVico(Vico $vico): Project
    {
        $this->vico = $vico;
        return $this;
    }

    /**
     * @return Client
     */
    public function getCreator(): Client
    {
        return $this->creator;
    }

    /**
     * @param Client $creator
     * @return Project
     */
    public function setCreator(Client $creator): Project
    {
        $this->creator = $creator;
        return $this;
    }

    /**
     * @return Collection<int, RatingQuestion>
     */
    public function getRatingQuestions(): Collection
    {
        return $this->ratingQuestions;
    }

    public function addRatingQuestion(RatingQuestion $ratingQuestion): self
    {
        if (!$this->ratingQuestions->contains($ratingQuestion)) {
            $this->ratingQuestions->add($ratingQuestion);
            $ratingQuestion->setProject($this);
        }

        return $this;
    }

    public function removeRatingQuestion(RatingQuestion $ratingQuestion): self
    {
        if ($this->ratingQuestions->removeElement($ratingQuestion)) {
            if ($ratingQuestion->getProject() === $this) {
                $ratingQuestion->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Feedback>
     */
    public function getFeedback(): Collection
    {
        return $this->feedback;
    }

    public function addFeedback(Feedback $feedback): self
    {
        if (!$this->feedback->contains($feedback)) {
            $this->feedback->add($feedback);
            $feedback->setProject($this);
        }

        return $this;
    }

    public function removeFeedback(Feedback $feedback): self
    {
        if ($this->feedback->removeElement($feedback)) {
            if ($feedback->getProject() === $this) {
                $feedback->setProject(null);
            }
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'vico' => $this->getVico()->getId(),
            'creator' => $this->getCreator()->getId(),
        ];
    }
}
