<?php

namespace App\Service;

use App\Entity\Feedback;
use App\Repository\FeedbackRepository;

class FeedbackService
{
    public function __construct(private readonly FeedbackRepository $feedbackRepository) {}

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->feedbackRepository->findAll();
    }

    /**
     * @param Feedback $feedback
     * @return Feedback
     */
    public function create(Feedback $feedback): Feedback
    {
        return $this->feedbackRepository->save($feedback, true);
    }

    /**
     * @param int $id
     * @return Feedback|null
     */
    public function get(int $id): ?Feedback
    {
        return $this->feedbackRepository->findOneBy(['id' => $id]);
    }

    /**
     * @param int $id
     * @return void
     */
    public function remove(int $id): void
    {
        $feedback = $this->feedbackRepository->findOneBy(['id' => $id]);

        if ($feedback) {
            $this->feedbackRepository->remove($feedback, true);
        }
    }
}