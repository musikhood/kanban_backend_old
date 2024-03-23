<?php

namespace App\Dashboard\Board\Domain\Handler;

use App\Dashboard\Board\Domain\Entity\Board;
use App\Dashboard\Board\Domain\Exception\BoardNotFoundException;
use App\Dashboard\Board\Domain\Exception\PermissionDeniedException;
use App\Dashboard\Board\Domain\Model\Query\FindSingleBoardQuery;
use App\Dashboard\Board\Domain\RepositoryPort\BoardRepositoryInterface;
use App\Shared\Domain\Cqrs\QueryHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class FindSingleBoardHandler implements QueryHandlerInterface
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
    public function __invoke(FindSingleBoardQuery $findBoardQuery): ?Board
    {
        /** @var ?Board $board */
        $board = $this->boardRepository->findOneBy([
            'id' => $findBoardQuery->getBoardId(),
        ]);

        if (!$board){
            throw new BoardNotFoundException();
        }

        if(!$board->userId()->equals($findBoardQuery->getUserId())){
            throw new PermissionDeniedException();
        }

        return $board;
    }
}