<?php

namespace App\Dashboard\Board\Application\Controller;

use App\Dashboard\Board\Application\Dto\UpdateBoardRequestDto;
use App\Dashboard\Board\Application\Model\Command\UpdateBoardCommand;
use App\Dashboard\Board\Domain\Entity\ValueObject\BoardId;
use App\Dashboard\Board\Domain\Entity\ValueObject\BoardName;
use App\Dashboard\Board\Domain\Redis\BoardRedisInterface;
use App\Dashboard\Shared\Application\Service\DashboardServiceInterface;
use App\Shared\Application\Bus\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class UpdateBoardController extends AbstractController
{
    public function __construct(
        private readonly DashboardServiceInterface $dashboardService,
        private readonly CommandBusInterface $commandBus,
        private readonly BoardRedisInterface $boardRedis
    )
    {
    }

    #[Route('/api/board/{boardId}', name: 'app_put_board', methods: ['PUT'])]
    public function index(string $boardId, #[MapRequestPayload] UpdateBoardRequestDto $updateBoardRequestDto): Response
    {
        $user = $this->dashboardService->findUser();

        $updateBoardCommand = new UpdateBoardCommand(
            $user->id(),
            new BoardId($boardId),
            new BoardName($updateBoardRequestDto->getName())
        );

        $this->commandBus->dispatch($updateBoardCommand);

        $this->boardRedis->clearCache();

        return new JsonResponse(['message'=>'Board Updated Successfully']);
    }
}