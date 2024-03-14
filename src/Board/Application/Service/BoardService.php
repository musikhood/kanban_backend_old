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
    private User $user;
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private Security $security
    ) {
        /** @var User $user */
        $user = $this->security->getUser();
        $this->user = $user;
    }

    /**
     * @throws Throwable
     */
    public function findBoard(string $boardId): FindBoardResponseDto
    {

        $findBoardQuery = new FindBoardQuery(
            $boardId,
            $this->user
        );

        /** @var Board $board */
        $board = $this->queryBus->handle($findBoardQuery);

        $columns = $board->columns();

        return new FindBoardResponseDto(
            $board->id()->uuid(),
            $this->user->email(),
            $board->name()->value(),
            $columns->toArray()
        );
    }

    /**
     * @throws Throwable
     */
    public function createBoard(string $boardName): CreateBoardResponseDto
    {
        $createBoardCommand = new CreateBoardCommand(
            $boardName,
            $this->user
        );

        $this->commandBus->dispatch($createBoardCommand);

        return new CreateBoardResponseDto(
            'Board created successfully'
        );
    }

    public function addColumn(string $boardId, string $columnName): CreateColumnResponseDto
    {
        $findBoardQuery = new FindBoardQuery(
            $boardId,
            $this->user
        );

        /** @var Board $board */
        $board = $this->queryBus->handle($findBoardQuery);

        $createColumnCommand = new CreateColumnCommand(
            $board,
            $columnName
        );

        $this->commandBus->dispatch($createColumnCommand);

        return new CreateColumnResponseDto(
            'Column created successfully'
        );

    }
}