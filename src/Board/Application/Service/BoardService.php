<?php

namespace App\Board\Application\Service;

use App\Board\Application\Dto\CreateBoardResponseDto;
use App\Board\Application\Dto\CreateColumnResponseDto;
use App\Board\Application\Dto\FindBoardResponseDto;
use App\Board\Application\Model\Command\CreateBoardCommand;
use App\Board\Application\Model\Command\CreateColumnCommand;
use App\Board\Application\Model\Query\FindBoardQuery;
use App\Board\Application\Port\BoardServiceInterface;
use App\Board\Domain\Entity\Board;
use App\Shared\Application\Bus\CommandBusInterface;
use App\Shared\Application\Bus\QueryBusInterface;
use App\User\Domain\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Throwable;

readonly class BoardService implements BoardServiceInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function findBoard(string $userId, string $boardId): FindBoardResponseDto
    {

        $board = $this->findBoardEntity($userId, $boardId);

        $columns = $board->columns();

        return new FindBoardResponseDto(
            $board->id()->uuid(),
            $board->user()->email(),
            $board->name()->value(),
            $columns->toArray()
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

    /**
     * @throws Throwable
     */
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