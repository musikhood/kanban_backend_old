<?php

namespace App\Dashboard\Board\Application\Controller;

use App\Dashboard\Board\Application\Model\Query\FindBoardQuery;
use App\Dashboard\Board\Domain\Entity\BoardId;
use App\Dashboard\Shared\Application\Service\DashboardServiceInterface;
use App\Shared\Application\Bus\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Throwable;

class FindBoardController extends AbstractController
{
    public function __construct(
        private readonly DashboardServiceInterface $dashboardService,
        private readonly QueryBusInterface $queryBus,
        private readonly NormalizerInterface $normalizer,
    ) {
    }

    /**
     * @throws Throwable
     */
    #[Route('/api/board/{boardId}', name: 'app_get_board', methods: ['GET'])]
    public function index(string $boardId): JsonResponse
    {
        $user = $this->dashboardService->findUser();

        $findBoardQuery = new FindBoardQuery(
            new BoardId($boardId),
            $user->id()
        );

        $board = $this->queryBus->handle($findBoardQuery);

        $response = $this->normalizer->normalize($board);

        return new JsonResponse($response);
    }
}
