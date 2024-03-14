<?php

namespace App\Board\Application\Handler;

use App\Board\Application\Exception\BoardNotFoundException;
use App\Board\Application\Model\Query\FindBoardQuery;
use App\Board\Domain\Entity\Board;
use App\Board\Domain\RepositoryPort\BoardRepositoryInterface;
use App\Shared\Application\Cqrs\QueryHandlerInterface;
use App\User\Application\Port\UserServiceInterface;
use App\User\Domain\Entity\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class FindBoardHandler implements QueryHandlerInterface
{
    public function __construct(
        private BoardRepositoryInterface $boardRepository,
        private UserServiceInterface $userService
    )
    {
    }

    /**
     * @throws BoardNotFoundException
     */
    public function __invoke(FindBoardQuery $findBoardQuery): ?Board
    {
        $user = $this->userService->findUserEntity($findBoardQuery->getUserId());

        $board = $this->boardRepository->findOneBy(
            [
                'id' => $findBoardQuery->getBoardId(),
                'user' => $user
            ]
        );

        if (!$board){
            throw new BoardNotFoundException();
        }

        return $board;
    }
}