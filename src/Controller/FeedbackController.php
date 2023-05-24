<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Form\FeedbackType;
use App\Service\FeedbackService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/feedback', name: 'feedback')]
class FeedbackController extends AbstractController
{
    #[Route('/', name: 'create_feedback', methods: ['POST'])]
    public function create(Request $request, FeedbackService $feedbackService): JsonResponse
    {
        $feedback = new Feedback();

        $form = $this->createForm(FeedbackType::class, $feedback);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $feedback = $feedbackService->create($form->getData());
            return $this->json([
                'code' => Response::HTTP_OK,
                'payload' => [
                    'feedback' => $feedback
                ]
            ]);
        }

        return $this->json([
            'code' => Response::HTTP_BAD_REQUEST,
            'error' => $form->getErrors()
        ]);

    }

    #[Route('/{id<\d+>}', name: 'update_feedback', methods: ['PUT'])]
    public function update(int $id, Request $request, FeedbackService $feedbackService): JsonResponse
    {
        $feedback = $feedbackService->get($id);

        $form = $this->createForm(FeedbackType::class, $feedback);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $feedback = $feedbackService->create($form->getData());

            return $this->json([
                'code' => Response::HTTP_OK,
                'payload' => [
                    'feedback' => $feedback
                ]
            ]);
        }

        return $this->json([
            'code' => Response::HTTP_BAD_REQUEST,
            'error' => $form->getErrors()
        ]);

    }

    #[Route('/', name: 'get_feedback', methods: ['GET'])]
    public function getFeedbacks(FeedbackService $feedbackService): JsonResponse
    {
        return $this->json([
            'code' => Response::HTTP_OK,
            'payload' => [
                'feedbacks' => $feedbackService->getAll()
            ]
        ]);
    }

    #[Route('/{id<\d+>}', name: 'delete_feedback', methods: ['DELETE'])]
    public function delete(int $id, FeedbackService $feedbackService): JsonResponse
    {
        $feedbackService->remove($id);

        return $this->json([
            'code' => Response::HTTP_OK,
        ]);
    }
}
