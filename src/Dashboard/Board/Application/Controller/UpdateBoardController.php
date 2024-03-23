<?php

namespace App\Dashboard\Board\Application\Controller;

use App\Dashboard\Board\Application\Dto\UpdateBoardRequestDto;
use App\Dashboard\Board\Application\Model\Command\UpdateBoardCommand;
use App\Dashboard\Board\Domain\Entity\BoardId;
use App\Dashboard\Board\Domain\Entity\BoardName;
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
    )
    {
    }

    #[Route('/api/board/{boardId}', name: 'app_put_board', methods: ['PUT'])]
    public function index(string $boardId, #[MapRequestPayload] UpdateBoardRequestDto $updateBoardRequestDto): Response
    {
        $userDto = $this->dashboardService->findUser();

        $updateBoardCommand = new UpdateBoardCommand(
            $userDto->getId(),
            new BoardId($boardId),
            new BoardName($updateBoardRequestDto->getName())
        );

        $this->commandBus->dispatch($updateBoardCommand);

        return new JsonResponse(['message'=>'Board Updated Successfully']);
    }
}