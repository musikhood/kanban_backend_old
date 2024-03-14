<?php

namespace App\Board\Application\Controller;

use App\Board\Application\Port\BoardServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Throwable;

class GetBoardController extends AbstractController
{
    public function __construct(
        private readonly BoardServiceInterface $boardService,
        private readonly NormalizerInterface $normalizer,
    ) {
    }

    /**
     * @throws Throwable
     */
    #[Route('/api/board/{boardId}', name: 'app_get_board', methods: ['GET'])]
    public function index(string $boardId): JsonResponse
    {
        $board = $this->boardService->findBoard($boardId);

        $response = $this->normalizer->normalize($board);

        return new JsonResponse($response);
    }
}
