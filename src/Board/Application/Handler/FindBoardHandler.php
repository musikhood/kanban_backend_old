<?php

namespace App\Board\Application\Handler;

use App\Board\Application\Exception\BoardNotFoundException;
use App\Board\Application\Model\Query\FindBoardQuery;
use App\Board\Domain\Entity\Board;
use App\Board\Domain\RepositoryPort\BoardRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class FindBoardHandler
{
    public function __construct(
        private BoardRepositoryInterface $boardRepository,
    )
    {
    }

    /**
     * @throws BoardNotFoundException
     */
    public function __invoke(FindBoardQuery $findBoardQuery): ?Board
    {
        $board = $this->boardRepository->findOneBy(['id'=>$findBoardQuery->getBoardId()]);

        if (!$board){
            throw new BoardNotFoundException($findBoardQuery);
        }

        return $board;
    }
}