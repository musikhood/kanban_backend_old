<?php

namespace App\Dashboard\Board\Application\Handler;

use App\Dashboard\Board\Application\Dto\BoardDto;
use App\Dashboard\Board\Application\Model\Query\FindBoardQuery;
use App\Dashboard\Board\Application\Service\BoardServiceInterface;
use App\Shared\Application\Cqrs\QueryHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class FindBoardHandler implements QueryHandlerInterface
{
    public function __construct(
        private BoardServiceInterface $boardService
    )
    {
    }

    public function __invoke(FindBoardQuery $findBoardQuery): BoardDto
    {
        $board = $this->boardService->findBoardEntity(
            $findBoardQuery->getUserId(),
            $findBoardQuery->getBoardId()
        );

        return $this->boardService->mapBoardEntityToDto($board);
    }
}