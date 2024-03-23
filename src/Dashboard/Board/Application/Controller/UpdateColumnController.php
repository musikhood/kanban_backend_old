<?php

namespace App\Dashboard\Board\Application\Controller;

use App\Dashboard\Board\Application\Dto\UpdateColumnRequestDto;
use App\Dashboard\Board\Application\Port\BoardServiceInterface;
use App\Dashboard\Board\Domain\Entity\BoardId;
use App\Dashboard\Board\Domain\Entity\ColumnColor;
use App\Dashboard\Board\Domain\Entity\ColumnId;
use App\Dashboard\Board\Domain\Entity\ColumnName;
use App\User\Domain\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UpdateColumnController extends AbstractController
{
    public function __construct(
        private readonly BoardServiceInterface $boardService,
        private readonly NormalizerInterface $normalizer
    )
    {
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/board/{boardId}/column/{columnId}', name: 'app_put_board_column', methods: ['PUT'])]
    public function index(string $boardId, string $columnId,  #[MapRequestPayload] UpdateColumnRequestDto $updateColumnRequestDto): Response{
        /** @var User $user */
        $user = $this->getUser();

        $response = $this->boardService->updateColumn(
            $user->id(),
            new BoardId($boardId),
            new ColumnId($columnId),
            new ColumnName($updateColumnRequestDto->getName()),
            new ColumnColor($updateColumnRequestDto->getColor())
        );

        $response = $this->normalizer->normalize($response);

        return new JsonResponse($response);
    }
}