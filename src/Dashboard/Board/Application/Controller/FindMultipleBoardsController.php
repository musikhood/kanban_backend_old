<?php

namespace App\Dashboard\Board\Application\Controller;

use App\Dashboard\Board\Application\Model\Query\FindMultipleBoardsQuery;
use App\Dashboard\Board\Application\Service\BoardRedisInterface;
use App\Dashboard\Shared\Application\Service\DashboardServiceInterface;
use App\Shared\Application\Bus\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Throwable;

class FindMultipleBoardsController extends AbstractController
{
    public function __construct(
        private readonly DashboardServiceInterface $dashboardService,
        private readonly QueryBusInterface $queryBus,
        private readonly NormalizerInterface $normalizer,
        private readonly BoardRedisInterface $boardRedis
    )
    {
    }

    /**
     * @throws Throwable
     */
    #[Route('/api/board', name: 'app_get_multiple_boards', methods: ['GET'])]
    public function index(): Response{
        $user =  $this->dashboardService->findUser();

        $findMultipleBoardsQuery = new FindMultipleBoardsQuery(
            $user->id()
        );
        
        $boards = $this->boardRedis->getDataFromCache(
            $user->id(),
            fn () => $this->queryBus->handle($findMultipleBoardsQuery)
        );

        $response = $this->normalizer->normalize($boards);

        return new JsonResponse($response);
    }
}