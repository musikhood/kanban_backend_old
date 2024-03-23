<?php

namespace App\Dashboard\Board\Application\Handler;

use App\Dashboard\Board\Application\Model\Command\UpdateBoardCommand;
use App\Dashboard\Board\Application\Model\Query\FindSingleBoardQuery;
use App\Dashboard\Board\Domain\Entity\Board;
use App\Dashboard\Board\Domain\Repository\BoardRepositoryInterface;
use App\Shared\Application\Bus\QueryBusInterface;
use App\Shared\Domain\Cqrs\CommandHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class UpdateBoardHandler implements CommandHandlerInterface
{
    public function __construct(
        private BoardRepositoryInterface $boardRepository,
        private QueryBusInterface $queryBus
    )
    {
    }

    public function __invoke(UpdateBoardCommand $updateBoardCommand): void
    {
        $findBoardQuery = new FindSingleBoardQuery(
            $updateBoardCommand->getBoardId(),
            $updateBoardCommand->getUserId()
        );

        /** @var Board $board */
        $board = $this->queryBus->handle($findBoardQuery);

        $board->rename($updateBoardCommand->getBoardName());

        $this->boardRepository->save($board);
    }
}