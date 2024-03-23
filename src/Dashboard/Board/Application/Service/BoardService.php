<?php

namespace App\Dashboard\Board\Application\Service;

use App\Account\Domain\Entity\AccountId;
use App\Dashboard\Board\Application\Dto\ColumnDto;
use App\Dashboard\Board\Application\Dto\CreateBoardResponseDto;
use App\Dashboard\Board\Application\Dto\CreateColumnResponseDto;
use App\Dashboard\Board\Application\Dto\FindBoardResponseDto;
use App\Dashboard\Board\Application\Dto\FindSingleBoardResponseDto;
use App\Dashboard\Board\Application\Dto\UpdateBoardResponseDto;
use App\Dashboard\Board\Application\Dto\UpdateColumnResponseDto;
use App\Dashboard\Board\Application\Model\Command\CreateBoardCommand;
use App\Dashboard\Board\Application\Model\Command\CreateColumnCommand;
use App\Dashboard\Board\Application\Model\Command\UpdateBoardCommand;
use App\Dashboard\Board\Application\Model\Command\UpdateColumnCommand;
use App\Dashboard\Board\Application\Model\Query\FindBoardQuery;
use App\Dashboard\Board\Application\Model\Query\FindSingleBoardQuery;
use App\Dashboard\Board\Application\Port\BoardServiceInterface;
use App\Dashboard\Board\Domain\Entity\Board;
use App\Dashboard\Board\Domain\Entity\BoardId;
use App\Dashboard\Board\Domain\Entity\BoardName;
use App\Dashboard\Board\Domain\Entity\Column;
use App\Dashboard\Board\Domain\Entity\ColumnColor;
use App\Dashboard\Board\Domain\Entity\ColumnId;
use App\Dashboard\Board\Domain\Entity\ColumnName;
use App\Shared\Application\Bus\CommandBusInterface;
use App\Shared\Application\Bus\QueryBusInterface;

readonly class BoardService implements BoardServiceInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
    ) {
    }

    public function findBoard(AccountId $userId): FindBoardResponseDto
    {
        $findBoardQuery = new FindBoardQuery(
            $userId
        );

        $boardsEntity = $this->queryBus->handle($findBoardQuery);

        $boards = [];

        /** @var Board $board */
        foreach ($boardsEntity as $board){
            $columns = $this->mapColumnsArrayToDtoArray($board->columns()->toArray());

            $boards[] = new FindSingleBoardResponseDto(
                $board->id()->value(),
                $board->userId()->value(),
                $board->name()->value(),
                $columns
            );
        }

        return new FindBoardResponseDto($boards);
    }
    public function findSingleBoard(AccountId $userId, BoardId $boardId): FindSingleBoardResponseDto
    {

        $findBoardQuery = new FindSingleBoardQuery(
            $boardId,
            $userId
        );

        /** @var Board $board */
        $board = $this->queryBus->handle($findBoardQuery);

        $columnsEntity = $board->columns();

        $columns = $this->mapColumnsArrayToDtoArray($columnsEntity->toArray());

        return new FindSingleBoardResponseDto(
            $board->id()->value(),
            $board->userId()->value(),
            $board->name()->value(),
            $columns
        );
    }
    public function createBoard(AccountId $userId, BoardName $boardName): CreateBoardResponseDto
    {
        $createBoardCommand = new CreateBoardCommand(
            $boardName,
            $userId
        );

        $this->commandBus->dispatch($createBoardCommand);

        return new CreateBoardResponseDto(
            'Board created successfully'
        );
    }
    public function updateBoard(AccountId $userId, BoardId $boardId, BoardName $boardName): UpdateBoardResponseDto
    {
        $updateBoardCommand = new UpdateBoardCommand(
            $userId,
            $boardId,
            $boardName
        );

        $this->commandBus->dispatch($updateBoardCommand);

        return new UpdateBoardResponseDto(
            'Board updated successfully'
        );
    }
    public function addColumn(AccountId $userId, BoardId $boardId, ColumnName $columnName, ColumnColor $columnColor): CreateColumnResponseDto
    {
        $createColumnCommand = new CreateColumnCommand(
            $userId,
            $boardId,
            $columnName,
            $columnColor
        );

        $this->commandBus->dispatch($createColumnCommand);

        return new CreateColumnResponseDto(
            'Column created successfully'
        );

    }

    public function updateColumn(AccountId $userId, BoardId $boardId, ColumnId $columnId, ColumnName $columnName, ColumnColor $columnColor): UpdateColumnResponseDto
    {
        $updateColumnCommand = new UpdateColumnCommand(
            $userId,
            $boardId,
            $columnId,
            $columnName,
            $columnColor
        );

        $this->commandBus->dispatch($updateColumnCommand);

        return new UpdateColumnResponseDto(
            'Column updated successfully'
        );
    }

    /**
     * @param array<Column> $columns
     * @return array<ColumnDto>
     */
    private function mapColumnsArrayToDtoArray(array $columns): array{
        $columnsDto = [];

        foreach ($columns as $item){
            $columnsDto[] = new ColumnDto(
                $item->id()->value(),
                $item->name()->value(),
                $item->color()->value(),
                $item->color()->hexToRgb()
            );
        }

        return $columnsDto;
    }
}