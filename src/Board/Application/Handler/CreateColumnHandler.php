<?php

namespace App\Board\Application\Handler;

use App\Board\Application\Exception\BoardNotFoundException;
use App\Board\Application\Model\Command\CreateColumnCommand;
use App\Board\Domain\Entity\Board;
use App\Board\Domain\Entity\ColumnId;
use App\Board\Domain\Entity\ColumnName;
use App\Board\Domain\RepositoryPort\BoardRepositoryInterface;
use App\Board\Domain\RepositoryPort\ColumnRepositoryInterface;
use App\Shared\Application\Cqrs\CommandHandlerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateColumnHandler implements CommandHandlerInterface
{
    public function __construct(
        private BoardRepositoryInterface $boardRepository,
        private ColumnRepositoryInterface $columnRepository,
        private EventDispatcherInterface $eventDispatcher,
    )
    {
    }

    /**
     * @throws BoardNotFoundException
     */
    public function __invoke(CreateColumnCommand $createColumnCommand): void
    {

        $board = $createColumnCommand->getBoard();

        $column = Board::createColumn(
            $board,
            new ColumnId(Uuid::uuid4()->toString()),
            new ColumnName($createColumnCommand->getName())
        );

        $board->addColumn($column);

        $this->columnRepository->save($column);

        foreach ($board->pullDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
    }
}