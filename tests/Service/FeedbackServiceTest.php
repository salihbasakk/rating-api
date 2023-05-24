<?php

namespace App\Tests\Service;

use App\Entity\Client;
use App\Entity\Feedback;
use App\Entity\Project;
use App\Repository\FeedbackRepository;
use App\Service\FeedbackService;
use PHPUnit\Framework\TestCase;

class FeedbackServiceTest extends TestCase
{
    private FeedbackRepository $feedbackRepository;
    private FeedbackService $feedbackService;

    protected function setUp(): void
    {
        $this->feedbackRepository = $this->createMock(FeedbackRepository::class);
        $this->feedbackService = new FeedbackService($this->feedbackRepository);
    }

    public function testGetAll(): void
    {
        $feedback1 = new Feedback();
        $feedback1->setComment('Great communication skills');

        $feedback2 = new Feedback();
        $feedback2->setComment('Appreciated. Well done!');

        $this->feedbackRepository->expects($this->once())
            ->method('findAll')
            ->willReturn([$feedback1, $feedback2]);

        $result = $this->feedbackService->getAll();

        $this->assertEquals([$feedback1, $feedback2], $result);
    }

    public function testCreate(): void
    {
        $project = new Project();
        $client = new Client();

        $expectedFeedback = (new Feedback())
            ->setComment('Great work quality')
            ->setOverallRating(4.5)
            ->setProject($project)
            ->setClient($client);

        $this->feedbackRepository->expects($this->once())
            ->method('save')
            ->willReturnCallback(function (Feedback $feedback) use ($expectedFeedback) {
                $this->assertEquals($expectedFeedback->getComment(), $feedback->getComment());
                $this->assertEquals($expectedFeedback->getOverallRating(), $feedback->getOverallRating());
                $this->assertEquals($expectedFeedback->getProject(), $feedback->getProject());
                $this->assertEquals($expectedFeedback->getClient(), $feedback->getClient());

                return $feedback;
            });

        $this->feedbackService->create($expectedFeedback);
    }

    public function testGet(): void
    {
        $project = new Project();
        $client = new Client();

        $feedback = (new Feedback())
            ->setComment('Great work quality')
            ->setOverallRating(4.5)
            ->setProject($project)
            ->setClient($client);

        $this->feedbackRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => 1])
            ->willReturn($feedback);

        $result = $this->feedbackService->get(1);

        $this->assertInstanceOf(Feedback::class, $result);

        $this->assertEquals($feedback->getComment(), $result->getComment());
        $this->assertEquals($feedback->getOverallRating(), $result->getOverallRating());
        $this->assertEquals($feedback->getProject(), $result->getProject());
        $this->assertEquals($feedback->getClient(), $result->getClient());
    }

    public function testRemove(): void
    {
        $project = new Project();
        $client = new Client();

        $feedback = (new Feedback())
            ->setComment('Great work quality')
            ->setOverallRating(4.5)
            ->setProject($project)
            ->setClient($client);

        $this->feedbackRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => 1])
            ->willReturn($feedback);

        $this->feedbackRepository->expects($this->once())
            ->method('remove')
            ->with($feedback);

        $this->feedbackService->remove(1);
    }
}