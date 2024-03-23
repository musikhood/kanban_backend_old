<?php

namespace App\Dashboard\Board\Application\Handler;

use App\Dashboard\Board\Application\Dto\FindBoardResponseDto;
use App\Dashboard\Board\Application\Dto\FindSingleBoardResponseDto;
use App\Dashboard\Board\Application\Model\Query\FindBoardQuery;
use App\Dashboard\Board\Domain\Entity\Board;
use App\Dashboard\Board\Domain\Repository\BoardRepositoryInterface;
use App\Shared\Domain\Cqrs\CommandHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class FindBoardHandler implements CommandHandlerInterface
{
    public function __construct(
        private BoardRepositoryInterface $boardRepository
    )
    {
    }

    /** @return array<Board> */
    public function __invoke(FindBoardQuery $findBoardQuery): FindBoardResponseDto
    {
        $boardsEntity =  $this->boardRepository->findBy(['userId'=>$findBoardQuery->getUserId()]);

        $boards = [];

        /** @var Board $board */
        foreach ($boardsEntity as $board){
            $boards[] = new FindSingleBoardResponseDto(
                $board->id(),
                $board->userId(),
                $board->name(),
            );
        }

        return new FindBoardResponseDto($boards);
    }
}