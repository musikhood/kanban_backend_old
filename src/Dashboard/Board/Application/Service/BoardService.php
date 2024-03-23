<?php

namespace App\Dashboard\Board\Application\Service;

use App\Dashboard\Board\Application\Dto\ColumnDto;
use App\Dashboard\Board\Application\Dto\FindSingleBoardResponseDto;
use App\Dashboard\Board\Application\Exception\PermissionDeniedException;
use App\Dashboard\Board\Domain\Entity\Board;
use App\Dashboard\Board\Domain\Entity\BoardId;
use App\Dashboard\Board\Domain\Exception\BoardNotFoundException;
use App\Dashboard\Board\Domain\Repository\BoardRepositoryInterface;
use App\Dashboard\User\Domain\Entity\UserId;

readonly class BoardService implements BoardServiceInterface
{
    public function __construct(
        private BoardRepositoryInterface $boardRepository
    )
    {
    }

    /**
     * @throws PermissionDeniedException
     * @throws BoardNotFoundException
     */
    public function findBoardEntity(UserId $userId, BoardId $boardId): Board
    {
        $board = $this->boardRepository->findOneBy([
            'id' => $boardId
        ]);

        if (!$board){
            throw new BoardNotFoundException();
        }

        if(!$board->userId()->equals($userId)){
            throw new PermissionDeniedException();
        }

        return $board;
    }

    public function mapBoardEntityToDto(Board $board): FindSingleBoardResponseDto
    {
        $columns = $board->columns();

        $columnsDto = [];

        foreach ($columns as $item){
            $columnsDto[] = new ColumnDto(
                $item->id()->value(),
                $item->name()->value(),
                $item->color()->value(),
                $item->color()->hexToRgb()
            );
        }

        return new FindSingleBoardResponseDto(
            $board->id(),
            $board->userId(),
            $board->name(),
            $columnsDto
        );
    }
}