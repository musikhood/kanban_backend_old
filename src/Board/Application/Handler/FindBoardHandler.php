<?php

namespace App\Board\Application\Handler;

use App\Board\Application\Exception\BoardNotFoundException;
use App\Board\Application\Exception\PermissionDeniedException;
use App\Board\Application\Model\Query\FindBoardQuery;
use App\Board\Domain\Entity\Board;
use App\Board\Domain\Entity\BoardId;
use App\Board\Domain\RepositoryPort\BoardRepositoryInterface;
use App\Shared\Application\Cqrs\QueryHandlerInterface;
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