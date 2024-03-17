<?php

namespace App\Board\Application\Handler;

use App\Board\Application\Model\Command\CreateColumnCommand;
use App\Board\Application\Port\BoardServiceInterface;
use App\Board\Domain\Entity\Board;
use App\Board\Domain\Entity\ColumnId;
use App\Board\Domain\Entity\ColumnName;
use App\Board\Domain\RepositoryPort\ColumnRepositoryInterface;
use App\Shared\Application\Cqrs\CommandHandlerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateColumnHandler implements CommandHandlerInterface
{
    public function __construct(
        private ColumnRepositoryInterface $columnRepository,
        private EventDispatcherInterface $eventDispatcher,
        private BoardServiceInterface $boardService,
    )
    {
    }

    public function __invoke(CreateColumnCommand $createColumnCommand): void
    {

        $board = $this->boardService->findBoardEntity(
            $createColumnCommand->getUserId()->value(),
            $createColumnCommand->getBoardId()->value()
        );

        $column = Board::createColumn(
            $board,
            new ColumnId(Uuid::uuid4()->toString()),
            $createColumnCommand->getName()
        );

        $board->addColumn($column);

        $this->columnRepository->save($column);

        foreach ($board->pullDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
    }
}