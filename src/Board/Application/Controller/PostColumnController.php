<?php

namespace App\Board\Application\Controller;

use App\Board\Application\Dto\CreateColumnRequestDto;
use App\Board\Application\Port\BoardServiceInterface;
use App\Board\Domain\Entity\BoardId;
use App\Board\Domain\Entity\ColumnColor;
use App\Board\Domain\Entity\ColumnName;
use App\User\Domain\Entity\User;
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
    #[Route('/api/board/{boardId}/column', name: 'app_post_board_column', methods: ['POST'])]
    public function index(string $boardId, #[MapRequestPayload] CreateColumnRequestDto $createColumnRequestDto): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        $response = $this->boardService->addColumn(
            $user->id(),
            new BoardId($boardId),
            new ColumnName($createColumnRequestDto->getName()),
            new ColumnColor($createColumnRequestDto->getColor())
        );

        $response = $this->normalizer->normalize($response);

        return new JsonResponse($response);
    }
}