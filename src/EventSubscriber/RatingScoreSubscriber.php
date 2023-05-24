<?php

namespace App\EventSubscriber;

use App\Entity\Feedback;
use App\Entity\Rating;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RatingScoreSubscriber implements EventSubscriberInterface
{
    public function __construct(protected EntityManagerInterface $entityManager) {}

    public static function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postUpdate,
            Events::preRemove,
        ];
    }

    public function postPersist(Rating $rating)
    {
        $this->updateOverallRating($rating->getFeedback());
    }

    public function postUpdate(Rating $ratings)
    {
        $this->updateOverallRating($ratings->getFeedback());
    }

    public function preRemove(Rating $ratings)
    {
        $this->updateOverallRating($ratings->getFeedback());
    }

    public function updateOverallRating(Feedback $feedback)
    {
        $ratingRepository = $this->entityManager->getRepository(Rating::class);
        $feedbackRepository = $this->entityManager->getRepository(Feedback::class);

        $totalRatingScore = $ratingRepository->getTotalRatingScoreCount($feedback);
        $totalRatingCount = $ratingRepository->getRatingCount($feedback);

        if ($totalRatingCount !== null && $totalRatingScore !== null) {
            $overallRating = $totalRatingScore['totalScore'] / $totalRatingCount['count'];
            $feedback->setOverallRating($overallRating);
        }

        $feedbackRepository->save($feedback, true);
    }
}
