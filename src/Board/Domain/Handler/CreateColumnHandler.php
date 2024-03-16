<?php

namespace App\Board\Domain\Handler;

use App\Board\Application\Port\BoardServiceInterface;
use App\Board\Domain\Entity\Board;
use App\Board\Domain\Entity\ColumnName;
use App\Board\Domain\Model\Command\CreateColumnCommand;
use App\Board\Infrastructure\Port\ColumnRepositoryInterface;
use App\Shared\Domain\Cqrs\CommandHandlerInterface;
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
            $createColumnCommand->getUserId(),
            $createColumnCommand->getBoardId()
        );

        $column = Board::createColumn(
            $board,
            new ColumnName($createColumnCommand->getName())
        );

        $this->columnRepository->save($column);

        foreach ($board->pullDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
    }
}