<?php

namespace App\Board\Application\Controller;

use App\Board\Application\Dto\CreateBoardRequestDto;
use App\Board\Application\Model\Command\CreateBoardCommand;
use App\Board\Application\Port\BoardServiceInterface;
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
        $response = $this->boardService->createBoard(
            $createBoardRequestDto->getName()
        );

        $response = $this->normalizer->normalize($response);

        return new JsonResponse($response);
    }
}