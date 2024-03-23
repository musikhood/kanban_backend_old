<?php

namespace App\Dashboard\Board\Application\Controller;

use App\Account\Domain\Entity\Account;
use App\Dashboard\Board\Application\Dto\CreateColumnRequestDto;
use App\Dashboard\Board\Application\Model\Command\CreateColumnCommand;
use App\Dashboard\Board\Domain\Entity\BoardId;
use App\Dashboard\Board\Domain\Entity\ColumnColor;
use App\Dashboard\Board\Domain\Entity\ColumnName;
use App\Dashboard\User\Application\Dto\FindUserResponseDto;
use App\Dashboard\User\Application\Model\Query\FindUserQuery;
use App\Shared\Application\Bus\CommandBusInterface;
use App\Shared\Application\Bus\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class PostColumnController extends AbstractController
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    /**
     * @throws Throwable
     */
    #[Route('/api/board/{boardId}/column', name: 'app_post_board_column', methods: ['POST'])]
    public function index(string $boardId, #[MapRequestPayload] CreateColumnRequestDto $createColumnRequestDto): JsonResponse
    {
        /** @var Account $account */
        $account = $this->getUser()->getAggregate();

        $findUserQuery = new FindUserQuery(
            $account->id()
        );

        /** @var FindUserResponseDto $userDto */
        $userDto = $this->queryBus->handle($findUserQuery);

        $createColumnCommand = new CreateColumnCommand(
            $userDto->getId(),
            new BoardId($boardId),
            new ColumnName($createColumnRequestDto->getName()),
            new ColumnColor($createColumnRequestDto->getColor())
        );

        $this->commandBus->dispatch($createColumnCommand);

        return new JsonResponse(['message'=>'Column Created Successfully']);
    }
}