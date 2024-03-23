<?php

namespace App\Dashboard\Board\Domain\Handler;

use App\Dashboard\Board\Domain\Entity\Board;
use App\Dashboard\Board\Domain\Entity\Column;
use App\Dashboard\Board\Domain\Entity\ColumnId;
use App\Dashboard\Board\Domain\Model\Command\CreateColumnCommand;
use App\Dashboard\Board\Domain\Model\Query\FindSingleBoardQuery;
use App\Dashboard\Board\Domain\RepositoryPort\ColumnRepositoryInterface;
use App\Shared\Application\Bus\QueryBusInterface;
use App\Shared\Domain\Cqrs\CommandHandlerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateColumnHandler implements CommandHandlerInterface
{
    public function __construct(
        private ColumnRepositoryInterface $columnRepository,
        private QueryBusInterface $queryBus
    )
    {
    }

    public function __invoke(CreateColumnCommand $createColumnCommand): void
    {

        $findBoardQuery = new FindSingleBoardQuery(
            $createColumnCommand->getBoardId(),
            $createColumnCommand->getUserId()
        );

        /** @var Board $board */
        $board = $this->queryBus->handle($findBoardQuery);

        $column = Column::createColumn(
            $board,
            new ColumnId(Uuid::uuid4()->toString()),
            $createColumnCommand->getName(),
            $createColumnCommand->getColor()
        );

        $board->addColumn($column);

        $this->columnRepository->save($column);
    }
}