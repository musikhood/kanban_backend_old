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
use App\Shared\Application\Bus\BusInterface;
use App\Shared\Application\Bus\CommandBusInterface;
use App\Shared\Application\Bus\QueryBusInterface;
use App\User\Application\Port\UserServiceInterface;
use Throwable;

readonly class BoardService implements BoardServiceInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private UserServiceInterface $userService
    ) {
    }

    /**
     * @throws Throwable
     */
    public function findBoard(string $boardId): FindBoardResponseDto
    {

        $findBoardQuery = new FindBoardQuery($boardId);

        /** @var Board $board */
        $board = $this->queryBus->handle($findBoardQuery);

        $user = $this->userService->findUser(
            $board->user()->uuid()
        );

        return new FindBoardResponseDto(
            $board->name()->value(),
            $user->getEmail()
        );
    }

    /**
     * @throws Throwable
     */
    public function createBoard(string $boardName): CreateBoardResponseDto
    {
        $createBoardCommand = new CreateBoardCommand($boardName);

        $this->commandBus->dispatch($createBoardCommand);

        return new CreateBoardResponseDto(
            'Board created successfully'
        );
    }

    public function addColumn(string $boardId, string $columnName): CreateColumnResponseDto
    {
        $createColumnCommand = new CreateColumnCommand(
            $boardId,
            $columnName
        );

        $this->commandBus->dispatch($createColumnCommand);

        return new CreateColumnResponseDto(
            'Column created successfully'
        );

    }
}