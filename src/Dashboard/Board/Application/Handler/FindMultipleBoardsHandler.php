<?php

namespace App\Dashboard\Board\Application\Handler;

use App\Dashboard\Board\Application\Dto\MultipleBoardsDto;
use App\Dashboard\Board\Application\Model\Query\FindMultipleBoardsQuery;
use App\Dashboard\Board\Application\Service\BoardServiceInterface;
use App\Dashboard\Board\Domain\Entity\Board;
use App\Dashboard\Board\Domain\Repository\BoardRepositoryInterface;
use App\Shared\Application\Cqrs\CommandHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class FindMultipleBoardsHandler implements CommandHandlerInterface
{
    public function __construct(
        private BoardRepositoryInterface $boardRepository,
        private BoardServiceInterface $boardService
    )
    {
    }

    public function __invoke(FindMultipleBoardsQuery $findBoardQuery): MultipleBoardsDto
    {
        $boardsEntity =  $this->boardRepository->findByUserId($findBoardQuery->getUserId());

        $boards = [];

        /** @var Board $board */
        foreach ($boardsEntity as $board){
            $boards[] = $this->boardService->mapBoardEntityToDto($board);
        }

        return new MultipleBoardsDto($boards);
    }
}