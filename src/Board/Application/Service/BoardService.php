<?php

namespace App\Board\Application\Service;

use App\Board\Application\Dto\ColumnDto;
use App\Board\Application\Dto\CreateBoardResponseDto;
use App\Board\Application\Dto\CreateColumnResponseDto;
use App\Board\Application\Dto\FindBoardResponseDto;
use App\Board\Application\Port\BoardServiceInterface;
use App\Board\Domain\Entity\Board;
use App\Board\Domain\Model\Command\CreateBoardCommand;
use App\Board\Domain\Model\Command\CreateColumnCommand;
use App\Board\Domain\Model\Query\FindBoardQuery;
use App\Shared\Application\Bus\CommandBusInterface;
use App\Shared\Application\Bus\QueryBusInterface;

readonly class BoardService implements BoardServiceInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
    ) {
    }
    public function findBoard(string $userId, string $boardId): FindBoardResponseDto
    {

        $board = $this->findBoardEntity($userId, $boardId);

        $columnsEntity = $board->getColumns();
        $columns = [];

        foreach ($columnsEntity as $columnEntity){
            $columns[] = new ColumnDto(
                $columnEntity->getId(),
                $columnEntity->getColumnName()->value()
            );
        }

        return new FindBoardResponseDto(
            $board->getId(),
            $board->getUser()->getEmail(),
            $board->getBoardName()->value(),
            $columns
        );
    }

    public function findBoardEntity(string $userId, string $boardId): Board
    {
        $findBoardQuery = new FindBoardQuery(
            $boardId,
            $userId
        );

        /** @var Board $board */
        $board = $this->queryBus->handle($findBoardQuery);

        return $board;
    }
    
    public function createBoard(string $userId, string $boardName): CreateBoardResponseDto
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

    public function addColumn(string $userId, string $boardId, string $columnName): CreateColumnResponseDto
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