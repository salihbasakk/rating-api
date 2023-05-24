<?php

namespace App\Service;

use App\Entity\Rating;
use App\Repository\RatingRepository;

class RatingService
{
    public function __construct(private readonly RatingRepository $ratingRepository) {}

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->ratingRepository->findAll();
    }

    /**
     * @param Rating $rating
     * @return Rating
     */
    public function create(Rating $rating): Rating
    {
        return $this->ratingRepository->save($rating, true);
    }

    /**
     * @param int $id
     * @return Rating|null
     */
    public function get(int $id): ?Rating
    {
        return $this->ratingRepository->findOneBy(['id' => $id]);
    }

    /**
     * @param int $id
     * @return void
     */
    public function remove(int $id): void
    {
        $rating = $this->ratingRepository->findOneBy(['id' => $id]);
        $this->ratingRepository->remove($rating, true);
    }
}