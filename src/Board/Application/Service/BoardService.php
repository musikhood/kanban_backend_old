<?php

namespace App\Board\Application\Service;

use App\Board\Application\Dto\ColumnDto;
use App\Board\Application\Dto\CreateBoardResponseDto;
use App\Board\Application\Dto\CreateColumnResponseDto;
use App\Board\Application\Dto\FindBoardResponseDto;
use App\Board\Application\Port\BoardServiceInterface;
use App\Board\Domain\Entity\Board;
use App\Board\Domain\Entity\BoardId;
use App\Board\Domain\Entity\BoardName;
use App\Board\Domain\Entity\Column;
use App\Board\Domain\Entity\ColumnName;
use App\Board\Domain\Model\Command\CreateBoardCommand;
use App\Board\Domain\Model\Command\CreateColumnCommand;
use App\Board\Domain\Model\Query\FindBoardQuery;
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
    public function findBoard(UserId $userId, BoardId $boardId): FindBoardResponseDto
    {

        $board = $this->findBoardEntity($userId, $boardId);

        $columnsEntity = $board->columns();

        $columns = [];

        /** @var Column $item */
        foreach ($columnsEntity as $item){
            $columns[] = new ColumnDto(
                $item->id()->value(),
                $item->name()->value()
            );
        }

        return new FindBoardResponseDto(
            $board->id()->value(),
            $board->userId()->value(),
            $board->name()->value(),
            $columns
        );
    }

    public function findBoardEntity(UserId $userId, BoardId $boardId): Board
    {
        $findBoardQuery = new FindBoardQuery(
            $boardId,
            $userId
        );

        /** @var Board $board */
        $board = $this->queryBus->handle($findBoardQuery);

        return $board;
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
}