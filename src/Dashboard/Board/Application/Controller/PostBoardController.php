<?php

namespace App\Dashboard\Board\Application\Controller;

use App\Dashboard\Board\Application\Dto\CreateBoardRequestDto;
use App\Dashboard\Board\Application\Port\BoardServiceInterface;
use App\Dashboard\Board\Domain\Entity\BoardName;
use App\User\Domain\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Throwable;

class PostBoardController extends AbstractController
{
    public function __construct(
        private readonly BoardServiceInterface $boardService,
        private readonly NormalizerInterface $normalizer
    ) {
    }

    /**
     * @throws Throwable
     */
    #[Route('/api/board', name: 'app_post_board', methods: ['POST'])]
    public function index(#[MapRequestPayload] CreateBoardRequestDto $createBoardRequestDto): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        $response = $this->boardService->createBoard(
            $user->id(),
            new BoardName($createBoardRequestDto->getName())
        );

        $response = $this->normalizer->normalize($response);

        return new JsonResponse($response);
    }
}