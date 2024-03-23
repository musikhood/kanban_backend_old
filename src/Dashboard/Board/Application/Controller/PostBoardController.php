<?php

namespace App\Dashboard\Board\Application\Controller;

use App\Account\Domain\Entity\Account;
use App\Dashboard\Board\Application\Dto\CreateBoardRequestDto;
use App\Dashboard\Board\Application\Model\Command\CreateBoardCommand;
use App\Dashboard\Board\Domain\Entity\BoardName;
use App\Dashboard\User\Application\Dto\FindUserResponseDto;
use App\Dashboard\User\Application\Model\Query\FindUserQuery;
use App\Shared\Application\Bus\CommandBusInterface;
use App\Shared\Application\Bus\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class PostBoardController extends AbstractController
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    /**
     * @throws Throwable
     */
    #[Route('/api/board', name: 'app_post_board', methods: ['POST'])]
    public function index(#[MapRequestPayload] CreateBoardRequestDto $createBoardRequestDto): JsonResponse
    {
        /** @var Account $account */
        $account = $this->getUser()->getAggregate();

        $findUserQuery = new FindUserQuery(
            $account->id()
        );

        /** @var FindUserResponseDto $userDto */
        $userDto = $this->queryBus->handle($findUserQuery);

        $createBoardCommand = new CreateBoardCommand(
            new BoardName($createBoardRequestDto->getName()),
            $userDto->getId()
        );

        $this->commandBus->dispatch($createBoardCommand);

        return new JsonResponse(['message'=>'Board created successfully']);
    }
}