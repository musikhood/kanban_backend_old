<?php

namespace App\Dashboard\Board\Application\Controller;

use App\Dashboard\Board\Application\Dto\UpdateBoardRequestDto;
use App\Dashboard\Board\Application\Port\BoardServiceInterface;
use App\Dashboard\Board\Domain\Entity\BoardId;
use App\Dashboard\Board\Domain\Entity\BoardName;
use App\User\Domain\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UpdateBoardController extends AbstractController
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
    #[Route('/api/board/{boardId}', name: 'app_put_board', methods: ['PUT'])]
    public function index(string $boardId, #[MapRequestPayload] UpdateBoardRequestDto $updateBoardRequestDto): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $response = $this->boardService->updateBoard(
            $user->id(),
            new BoardId($boardId),
            new BoardName($updateBoardRequestDto->getName())
        );

        $response = $this->normalizer->normalize($response);

        return new JsonResponse($response);
    }
}