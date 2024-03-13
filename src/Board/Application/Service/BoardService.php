<?php

namespace App\Board\Application\Service;

use App\Board\Application\Dto\CreateBoardResponseDto;
use App\Board\Application\Dto\FindBoardResponseDto;
use App\Board\Application\Model\Command\CreateBoardCommand;
use App\Board\Application\Model\Query\FindBoardQuery;
use App\Board\Application\Port\BoardServiceInterface;
use App\Board\Domain\Entity\Board;
use App\Shared\Application\Bus\CQBus;
use Throwable;

readonly class BoardService implements BoardServiceInterface
{
    public function __construct(
        private CQBus $bus,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function findBoard(string $boardId): FindBoardResponseDto
    {

        $findBoardQuery = new FindBoardQuery($boardId);

        /** @var Board $board */
        $board = $this->bus->dispatch($findBoardQuery);

        return new FindBoardResponseDto(
            $board->name()->value(),
            $board->user()->uuid()
        );
    }

    /**
     * @throws Throwable
     */
    public function createBoard(string $boardName): CreateBoardResponseDto
    {
        $createBoardCommand = new CreateBoardCommand($boardName);

        $this->bus->dispatch($createBoardCommand);

        return new CreateBoardResponseDto(
            'Board created successfully'
        );
    }
}