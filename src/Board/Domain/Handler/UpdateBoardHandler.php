<?php

namespace App\Board\Domain\Handler;

use App\Board\Domain\Entity\Board;
use App\Board\Domain\Model\Command\UpdateBoardCommand;
use App\Board\Domain\Model\Query\FindSingleBoardQuery;
use App\Board\Domain\RepositoryPort\BoardRepositoryInterface;
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