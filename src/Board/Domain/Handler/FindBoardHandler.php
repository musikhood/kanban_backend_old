<?php

namespace App\Board\Domain\Handler;

use App\Board\Domain\Entity\Board;
use App\Board\Domain\Model\Query\FindBoardQuery;
use App\Board\Domain\RepositoryPort\BoardRepositoryInterface;
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