<?php

namespace App\Board\Domain\Handler;

use App\Board\Domain\Entity\Board;
use App\Board\Domain\Exception\BoardNotFoundException;
use App\Board\Domain\Exception\PermissionDeniedException;
use App\Board\Domain\Model\Query\FindBoardQuery;
use App\Board\Domain\RepositoryPort\BoardRepositoryInterface;
use App\Shared\Domain\Cqrs\QueryHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class FindBoardHandler implements QueryHandlerInterface
{
    public function __construct(
        private BoardRepositoryInterface $boardRepository,
    )
    {
    }

    /**
     * @throws BoardNotFoundException
     * @throws PermissionDeniedException
     */
    public function __invoke(FindBoardQuery $findBoardQuery): ?Board
    {
        /** @var Board|null $board */
        $board = $this->boardRepository->findOneBy([
            'id' => $findBoardQuery->getBoardId(),
        ]);

        if (!$board){
            throw new BoardNotFoundException();
        }

        if($board->userId()->value() !== $findBoardQuery->getUserId()->value()){
            throw new PermissionDeniedException();
        }

        return $board;
    }
}