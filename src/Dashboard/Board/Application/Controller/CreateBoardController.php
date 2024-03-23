<?php

namespace App\Dashboard\Board\Application\Controller;

use App\Dashboard\Board\Application\Dto\CreateBoardRequestDto;
use App\Dashboard\Board\Application\Model\Command\CreateBoardCommand;
use App\Dashboard\Board\Domain\Entity\BoardName;
use App\Dashboard\Board\Domain\Redis\BoardRedisInterface;
use App\Dashboard\Shared\Application\Service\DashboardServiceInterface;
use App\Shared\Application\Bus\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class CreateBoardController extends AbstractController
{
    public function __construct(
        private readonly DashboardServiceInterface $dashboardService,
        private readonly CommandBusInterface $commandBus,
        private readonly BoardRedisInterface $boardRedis
    ) {
    }

    /**
     * @throws Throwable
     */
    #[Route('/api/board', name: 'app_post_board', methods: ['POST'])]
    public function index(#[MapRequestPayload] CreateBoardRequestDto $createBoardRequestDto): JsonResponse
    {
        $user = $this->dashboardService->findUser();

        $createBoardCommand = new CreateBoardCommand(
            new BoardName($createBoardRequestDto->getName()),
            $user->id()
        );

        $this->commandBus->dispatch($createBoardCommand);

        $this->boardRedis->clearCache();

        return new JsonResponse(['message'=>'Board created successfully']);
    }
}