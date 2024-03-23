<?php

namespace App\Dashboard\Board\Application\Controller;

use App\Dashboard\Board\Application\Model\Query\FindBoardQuery;
use App\Dashboard\Shared\Application\Service\DashboardServiceInterface;
use App\Shared\Application\Bus\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class GetBoardController extends AbstractController
{
    public function __construct(
        private readonly DashboardServiceInterface $dashboardService,
        private readonly QueryBusInterface $queryBus,
        private readonly NormalizerInterface $normalizer
    )
    {
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/board', name: 'app_get_board', methods: ['GET'])]
    public function index(): Response{
        $userDto =  $this->dashboardService->findUser();

        $findBoardQuery = new FindBoardQuery(
            $userDto->getId()
        );

        $boards = $this->queryBus->handle($findBoardQuery);

        $response = $this->normalizer->normalize($boards);

        return new JsonResponse($response);
    }
}