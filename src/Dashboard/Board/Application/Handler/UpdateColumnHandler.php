<?php

namespace App\Dashboard\Board\Application\Handler;

use App\Dashboard\Board\Application\Model\Command\UpdateColumnCommand;
use App\Dashboard\Board\Application\Service\BoardServiceInterface;
use App\Dashboard\Board\Domain\Exception\ColumnNotFoundException;
use App\Dashboard\Board\Domain\Repository\BoardRepositoryInterface;
use App\Dashboard\Board\Domain\Repository\ColumnRepositoryInterface;
use App\Shared\Domain\Cqrs\CommandHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class UpdateColumnHandler implements CommandHandlerInterface
{
    public function __construct(
        private BoardRepositoryInterface $boardRepository,
        private ColumnRepositoryInterface $columnRepository,
        private BoardServiceInterface $boardService
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
            $updateColumnCommand->getColumnName(),
            $updateColumnCommand->getColumnColor()
        );

        $this->columnRepository->save($column);
    }
}