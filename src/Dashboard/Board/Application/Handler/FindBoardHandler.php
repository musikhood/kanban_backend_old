<?php

namespace App\Dashboard\Board\Application\Handler;

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
    public function __invoke(FindBoardQuery $findBoardQuery): array
    {
        return $this->boardRepository->findBy(['userId'=>$findBoardQuery->getUserId()]);
    }
}