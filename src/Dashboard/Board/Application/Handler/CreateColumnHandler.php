<?php

namespace App\Dashboard\Board\Application\Handler;

use App\Dashboard\Board\Application\Model\Command\CreateColumnCommand;
use App\Dashboard\Board\Application\Service\BoardServiceInterface;
use App\Dashboard\Board\Domain\Entity\Column;
use App\Dashboard\Board\Domain\Entity\ColumnId;
use App\Dashboard\Board\Domain\Repository\ColumnRepositoryInterface;
use App\Shared\Application\Cqrs\CommandHandlerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateColumnHandler implements CommandHandlerInterface
{
    public function __construct(
        private ColumnRepositoryInterface $columnRepository,
        private BoardServiceInterface $boardService
    )
    {
    }

    public function __invoke(CreateColumnCommand $createColumnCommand): void
    {
        $board = $this->boardService->findBoardEntity(
            $createColumnCommand->getUserId(),
            $createColumnCommand->getBoardId()
        );

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