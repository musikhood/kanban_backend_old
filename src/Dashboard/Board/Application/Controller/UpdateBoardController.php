<?php

namespace App\Dashboard\Board\Application\Controller;

use App\Account\Domain\Entity\Account;
use App\Dashboard\Board\Application\Dto\UpdateBoardRequestDto;
use App\Dashboard\Board\Application\Model\Command\UpdateBoardCommand;
use App\Dashboard\Board\Application\Port\BoardServiceInterface;
use App\Dashboard\Board\Domain\Entity\BoardId;
use App\Dashboard\Board\Domain\Entity\BoardName;
use App\Dashboard\User\Application\Dto\FindUserResponseDto;
use App\Dashboard\User\Application\Model\Query\FindUserQuery;
use App\Shared\Application\Bus\CommandBusInterface;
use App\Shared\Application\Bus\QueryBusInterface;
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
        private readonly QueryBusInterface $queryBus,
        private readonly CommandBusInterface $commandBus,
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
        /** @var Account $account */
        $account = $this->getUser()->getAggregate();

        $findUserQuery = new FindUserQuery(
            $account->id()
        );

        /** @var FindUserResponseDto $userDto */
        $userDto = $this->queryBus->handle($findUserQuery);

        $updateBoardCommand = new UpdateBoardCommand(
            $userDto->getId(),
            new BoardId($boardId),
            new BoardName($updateBoardRequestDto->getName())
        );

        $this->commandBus->dispatch($updateBoardCommand);

        return new JsonResponse(['Board Updated Successfully']);
    }
}