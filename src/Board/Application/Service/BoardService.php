<?php

namespace App\Board\Application\Service;

use App\Board\Application\Dto\ColumnDto;
use App\Board\Application\Dto\CreateBoardResponseDto;
use App\Board\Application\Dto\CreateColumnResponseDto;
use App\Board\Application\Dto\FindBoardResponseDto;
use App\Board\Application\Dto\FindSingleBoardResponseDto;
use App\Board\Application\Dto\UpdateBoardResponseDto;
use App\Board\Application\Dto\UpdateColumnResponseDto;
use App\Board\Application\Port\BoardServiceInterface;
use App\Board\Domain\Entity\Board;
use App\Board\Domain\Entity\BoardId;
use App\Board\Domain\Entity\BoardName;
use App\Board\Domain\Entity\Column;
use App\Board\Domain\Entity\ColumnId;
use App\Board\Domain\Entity\ColumnName;
use App\Board\Domain\Model\Command\CreateBoardCommand;
use App\Board\Domain\Model\Command\CreateColumnCommand;
use App\Board\Domain\Model\Command\UpdateBoardCommand;
use App\Board\Domain\Model\Command\UpdateColumnCommand;
use App\Board\Domain\Model\Query\FindBoardQuery;
use App\Board\Domain\Model\Query\FindSingleBoardQuery;
use App\Shared\Application\Bus\CommandBusInterface;
use App\Shared\Application\Bus\QueryBusInterface;
use App\Shared\Domain\ValueObject\UserId;

readonly class BoardService implements BoardServiceInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
    ) {
    }

    public function findBoard(UserId $userId): FindBoardResponseDto
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
    public function findSingleBoard(UserId $userId, BoardId $boardId): FindSingleBoardResponseDto
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
    public function createBoard(UserId $userId, BoardName $boardName): CreateBoardResponseDto
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
    public function updateBoard(UserId $userId, BoardId $boardId, BoardName $boardName): UpdateBoardResponseDto
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
    public function addColumn(UserId $userId, BoardId $boardId, ColumnName $columnName): CreateColumnResponseDto
    {
        $createColumnCommand = new CreateColumnCommand(
            $userId,
            $boardId,
            $columnName
        );

        $this->commandBus->dispatch($createColumnCommand);

        return new CreateColumnResponseDto(
            'Column created successfully'
        );

    }

    public function updateColumn(UserId $userId, BoardId $boardId, ColumnId $columnId, ColumnName $columnName): UpdateColumnResponseDto
    {
        $updateColumnCommand = new UpdateColumnCommand(
            $userId,
            $boardId,
            $columnId,
            $columnName
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
                $item->name()->value()
            );
        }

        return $columnsDto;
    }
}