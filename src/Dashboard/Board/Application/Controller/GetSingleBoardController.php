<?php

namespace App\Dashboard\Board\Application\Controller;

use App\Dashboard\Board\Application\Port\BoardServiceInterface;
use App\Dashboard\Board\Domain\Entity\BoardId;
use App\User\Domain\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Throwable;

class GetSingleBoardController extends AbstractController
{
    public function __construct(
        private readonly BoardServiceInterface $boardService,
        private readonly NormalizerInterface $normalizer,
    ) {
    }

    /**
     * @throws Throwable
     */
    #[Route('/api/board/{boardId}', name: 'app_get_single_board', methods: ['GET'])]
    public function index(string $boardId): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        $board = $this->boardService->findSingleBoard(
            $user->id(),
            new BoardId($boardId)
        );

        $response = $this->normalizer->normalize($board);

        return new JsonResponse($response);
    }
}
