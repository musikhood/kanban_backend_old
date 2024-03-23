<?php

namespace App\Dashboard\Board\Application\Controller;

use App\Dashboard\Board\Application\Dto\UpdateColumnRequestDto;
use App\Dashboard\Board\Application\Model\Command\UpdateColumnCommand;
use App\Dashboard\Board\Domain\Entity\BoardId;
use App\Dashboard\Board\Domain\Entity\ColumnColor;
use App\Dashboard\Board\Domain\Entity\ColumnId;
use App\Dashboard\Board\Domain\Entity\ColumnName;
use App\Dashboard\Shared\Application\Service\DashboardServiceInterface;
use App\Shared\Application\Bus\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class UpdateColumnController extends AbstractController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly DashboardServiceInterface $dashboardService
    )
    {
    }

    #[Route('/api/board/{boardId}/column/{columnId}', name: 'app_put_board_column', methods: ['PUT'])]
    public function index(string $boardId, string $columnId,  #[MapRequestPayload] UpdateColumnRequestDto $updateColumnRequestDto): Response{
        $user = $this->dashboardService->findUser();

        $updateColumnCommand = new UpdateColumnCommand(
            $user->getId(),
            new BoardId($boardId),
            new ColumnId($columnId),
            new ColumnName($updateColumnRequestDto->getName()),
            new ColumnColor($updateColumnRequestDto->getColor())
        );

        $this->commandBus->dispatch($updateColumnCommand);

        return new JsonResponse(['message'=>'Column Updated Successfully']);
    }
}