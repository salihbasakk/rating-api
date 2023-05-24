<?php

namespace App\Controller;

use App\Entity\Rating;
use App\Form\RatingType;
use App\Service\RatingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rating', name: 'rating')]
class RatingController extends AbstractController
{
    #[Route('/', name: 'create_rating', methods: ['POST'])]
    public function create(Request $request, RatingService $ratingService): JsonResponse
    {
        $rating = new Rating();

        $form = $this->createForm(RatingType::class, $rating);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $rating = $ratingService->create($form->getData());

            return $this->json([
                'code' => Response::HTTP_OK,
                'payload' => [
                    'ratings' => $rating
                ]
            ]);
        }

        return $this->json([
            'code' => Response::HTTP_BAD_REQUEST,
            'error' => $form->getErrors()
        ]);

    }

    #[Route('/{id<\d+>}', name: 'update_rating', methods: ['PUT'])]
    public function update(int $id, Request $request, RatingService $ratingService): JsonResponse
    {
        $rating = $ratingService->get($id);

        $form = $this->createForm(RatingType::class, $rating);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $rating = $ratingService->create($form->getData());

            return $this->json([
                'code' => Response::HTTP_OK,
                'payload' => [
                    'ratings' => $rating
                ]
            ]);
        }

        return $this->json([
            'code' => Response::HTTP_BAD_REQUEST,
            'error' => $form->getErrors()
        ]);

    }

    #[Route('/', name: 'get_rating', methods: ['GET'])]
    public function getRatings(RatingService $ratingService): JsonResponse
    {
        return $this->json([
            'code' => Response::HTTP_OK,
            'payload' => [
                'ratings' => $ratingService->getAll()
            ]
        ]);
    }

    #[Route('/{id<\d+>}', name: 'delete_rating', methods: ['DELETE'])]
    public function delete(int $id, RatingService $ratingService): JsonResponse
    {
        $ratingService->remove($id);

        return $this->json([
            'code' => Response::HTTP_OK,
        ]);
    }
}
