<?php

namespace App\Board\Application\Controller;

use App\Board\Application\Dto\CreateBoardRequestDto;
use App\Board\Application\Dto\CreateColumnRequestDto;
use App\Board\Application\Model\Command\CreateBoardCommand;
use App\Board\Application\Port\BoardServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Throwable;

class PostColumnController extends AbstractController
{
    public function __construct(
        private readonly BoardServiceInterface $boardService,
        private readonly NormalizerInterface $normalizer
    ) {
    }

    /**
     * @throws Throwable
     */
    #[Route('/api/board/column', name: 'app_post_board_column', methods: ['POST'])]
    public function index(#[MapRequestPayload] CreateColumnRequestDto $createColumnRequestDto): JsonResponse
    {
        $response = $this->boardService->addColumn(
            $createColumnRequestDto->getBoardId(),
            $createColumnRequestDto->getName()
        );

        $response = $this->normalizer->normalize($response);

        return new JsonResponse($response);
    }
}