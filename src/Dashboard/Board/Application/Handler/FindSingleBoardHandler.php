<?php

namespace App\Dashboard\Board\Application\Handler;

use App\Dashboard\Board\Application\Dto\FindSingleBoardResponseDto;
use App\Dashboard\Board\Application\Model\Query\FindSingleBoardQuery;
use App\Dashboard\Board\Application\Service\BoardServiceInterface;
use App\Shared\Domain\Cqrs\QueryHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class FindSingleBoardHandler implements QueryHandlerInterface
{
    public function __construct(
        private BoardServiceInterface $boardService
    )
    {
    }

    public function __invoke(FindSingleBoardQuery $findBoardQuery): FindSingleBoardResponseDto
    {
        $board = $this->boardService->findBoardEntity(
            $findBoardQuery->getUserId(),
            $findBoardQuery->getBoardId()
        );

        return new FindSingleBoardResponseDto(
            $board->id(),
            $board->userId(),
            $board->name()
        );
    }
}