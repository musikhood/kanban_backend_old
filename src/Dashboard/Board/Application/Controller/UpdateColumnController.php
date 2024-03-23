<?php

namespace App\Dashboard\Board\Application\Controller;

use App\Account\Domain\Entity\Account;
use App\Dashboard\Board\Application\Dto\UpdateColumnRequestDto;
use App\Dashboard\Board\Application\Model\Command\UpdateColumnCommand;
use App\Dashboard\Board\Application\Port\BoardServiceInterface;
use App\Dashboard\Board\Domain\Entity\BoardId;
use App\Dashboard\Board\Domain\Entity\ColumnColor;
use App\Dashboard\Board\Domain\Entity\ColumnId;
use App\Dashboard\Board\Domain\Entity\ColumnName;
use App\Dashboard\User\Application\Dto\FindUserResponseDto;
use App\Dashboard\User\Application\Model\Query\FindUserQuery;
use App\Shared\Application\Bus\CommandBusInterface;
use App\Shared\Application\Bus\QueryBusInterface;
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
        private readonly QueryBusInterface $queryBus,
        private readonly CommandBusInterface $commandBus,
        private readonly NormalizerInterface $normalizer
    )
    {
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/board/{boardId}/column/{columnId}', name: 'app_put_board_column', methods: ['PUT'])]
    public function index(string $boardId, string $columnId,  #[MapRequestPayload] UpdateColumnRequestDto $updateColumnRequestDto): Response{
        /** @var Account $account */
        $account = $this->getUser()->getAggregate();

        $findUserQuery = new FindUserQuery(
            $account->id()
        );

        /** @var FindUserResponseDto $userDto */
        $userDto = $this->queryBus->handle($findUserQuery);

        $updateColumnCommand = new UpdateColumnCommand(
            $userDto->getId(),
            new BoardId($boardId),
            new ColumnId($columnId),
            new ColumnName($updateColumnRequestDto->getName()),
            new ColumnColor($updateColumnRequestDto->getColor())
        );

        $this->commandBus->dispatch($updateColumnCommand);

        return new JsonResponse(['message'=>'Column Updated Successfully']);
    }
}