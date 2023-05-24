<?php

namespace App\Tests\Service;

use App\Entity\Rating;
use App\Entity\RatingQuestion;
use App\Repository\RatingRepository;
use App\Service\RatingService;
use PHPUnit\Framework\TestCase;

class RatingServiceTest extends TestCase
{
    private RatingService $ratingService;
    private RatingRepository $ratingRepository;

    protected function setUp(): void
    {
        $this->ratingRepository = $this->createMock(RatingRepository::class);
        $this->ratingService = new RatingService($this->ratingRepository);
    }

    public function testGetAll(): void
    {
        $rating1 = new Rating();

        $question1 = new RatingQuestion();
        $question1->setQuestion('How was your experience?');

        $rating1->setRatingQuestion($question1);
        $rating1->setScore(5);

        $rating2 = new Rating();

        $question2 = new RatingQuestion();
        $question2->setQuestion('How satistied are you?');

        $rating2->setRatingQuestion($question2);
        $rating2->setScore(5);

        $this->ratingRepository->expects($this->once())
            ->method('findAll')
            ->willReturn([$rating1, $rating2]);

        $result = $this->ratingService->getAll();

        $this->assertCount(2, $result);
        $this->assertSame($rating1, $result[0]);
        $this->assertSame($rating2, $result[1]);
    }

    public function testCreate(): void
    {
        $rating = new Rating();

        $this->ratingRepository->expects($this->once())
            ->method('save')
            ->with($rating, true)
            ->willReturn($rating);

        $result = $this->ratingService->create($rating);

        $this->assertSame($rating, $result);
    }

    public function testGet(): void
    {
        $rating = new Rating();

        $this->ratingRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => 1])
            ->willReturn($rating);

        $result = $this->ratingService->get(1);

        $this->assertSame($rating, $result);
    }

    public function testRemove(): void
    {
        $rating = new Rating();

        $this->ratingRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => 1])
            ->willReturn($rating);

        $this->ratingRepository->expects($this->once())
            ->method('remove')
            ->with($rating, true);

        $this->ratingService->remove(1);
    }
}