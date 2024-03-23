<?php

namespace App\Dashboard\Board\Domain\Handler;

use App\Dashboard\Board\Domain\Entity\Board;
use App\Dashboard\Board\Domain\Model\Command\UpdateBoardCommand;
use App\Dashboard\Board\Domain\Model\Query\FindSingleBoardQuery;
use App\Dashboard\Board\Domain\RepositoryPort\BoardRepositoryInterface;
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