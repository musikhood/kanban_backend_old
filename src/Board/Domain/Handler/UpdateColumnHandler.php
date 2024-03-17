<?php

namespace App\Board\Domain\Handler;

use App\Board\Domain\Entity\Board;
use App\Board\Domain\Exception\ColumnNotFoundException;
use App\Board\Domain\Model\Command\UpdateColumnCommand;
use App\Board\Domain\Model\Query\FindSingleBoardQuery;
use App\Board\Domain\RepositoryPort\ColumnRepositoryInterface;
use App\Shared\Application\Bus\QueryBusInterface;
use App\Shared\Domain\Cqrs\CommandHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class UpdateColumnHandler implements CommandHandlerInterface
{
    public function __construct(
        private ColumnRepositoryInterface $columnRepository,
        private QueryBusInterface $queryBus
    )
    {
    }

    /**
     * @throws ColumnNotFoundException
     */
    public function __invoke(UpdateColumnCommand $updateColumnCommand): void
    {
        $findBoardQuery = new FindSingleBoardQuery(
            $updateColumnCommand->getBoardId(),
            $updateColumnCommand->getUserId()
        );

        /** @var Board $board */
        $board = $this->queryBus->handle($findBoardQuery);

        $column = $board->changeColumn(
            $updateColumnCommand->getColumnId(),
            $updateColumnCommand->getColumnName(),
            $updateColumnCommand->getColumnColor()
        );

        $this->columnRepository->save($column);
    }
}