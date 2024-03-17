<?php

namespace App\Board\Domain\Handler;

use App\Board\Domain\Entity\Board;
use App\Board\Domain\Entity\ColumnId;
use App\Board\Domain\Model\Command\CreateColumnCommand;
use App\Board\Domain\Model\Query\FindSingleBoardQuery;
use App\Board\Domain\RepositoryPort\ColumnRepositoryInterface;
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
        private EventDispatcherInterface $eventDispatcher,
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

        $column = Board::createColumn(
            $board,
            new ColumnId(Uuid::uuid4()->toString()),
            $createColumnCommand->getName(),
            $createColumnCommand->getColor()
        );

        $board->addColumn($column);

        $this->columnRepository->save($column);

        foreach ($board->pullDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
    }
}