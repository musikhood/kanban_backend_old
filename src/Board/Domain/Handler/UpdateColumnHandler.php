<?php

namespace App\Board\Domain\Handler;

use App\Board\Application\Port\BoardServiceInterface;
use App\Board\Domain\Exception\ColumnNotFoundException;
use App\Board\Domain\Model\Command\UpdateColumnCommand;
use App\Board\Domain\RepositoryPort\ColumnRepositoryInterface;
use App\Shared\Domain\Cqrs\CommandHandlerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class UpdateColumnHandler implements CommandHandlerInterface
{
    public function __construct(
        private BoardServiceInterface $boardService,
        private ColumnRepositoryInterface $columnRepository,
        private EventDispatcherInterface $eventDispatcher
    )
    {
    }

    /**
     * @throws ColumnNotFoundException
     */
    public function __invoke(UpdateColumnCommand $updateColumnCommand): void
    {
        $board = $this->boardService->findBoardEntity(
            $updateColumnCommand->getUserId(),
            $updateColumnCommand->getBoardId()
        );

        $column = $board->changeColumn(
            $updateColumnCommand->getColumnId(),
            $updateColumnCommand->getColumnName()
        );

        $this->columnRepository->save($column);

        foreach ($board->pullDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
    }
}