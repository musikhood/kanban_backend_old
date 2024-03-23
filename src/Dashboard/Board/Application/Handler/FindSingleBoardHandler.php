<?php

namespace App\Dashboard\Board\Application\Handler;

use App\Dashboard\Board\Application\Dto\FindSingleBoardResponseDto;
use App\Dashboard\Board\Application\Exception\PermissionDeniedException;
use App\Dashboard\Board\Application\Model\Query\FindSingleBoardQuery;
use App\Dashboard\Board\Domain\Exception\BoardNotFoundException;
use App\Dashboard\Board\Domain\Repository\BoardRepositoryInterface;
use App\Shared\Domain\Cqrs\QueryHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class FindSingleBoardHandler implements QueryHandlerInterface
{
    public function __construct(
        private BoardRepositoryInterface $boardRepository
    )
    {
    }

    /**
     * @throws BoardNotFoundException
     * @throws PermissionDeniedException
     */
    public function __invoke(FindSingleBoardQuery $findBoardQuery): FindSingleBoardResponseDto
    {
        $board = $this->boardRepository->findOneBy([
            'id' => $findBoardQuery->getBoardId()
        ]);

        if (!$board){
            throw new BoardNotFoundException();
        }

        if(!$board->userId()->equals($findBoardQuery->getUserId())){
            throw new PermissionDeniedException();
        }

        return new FindSingleBoardResponseDto(
            $board->id(),
            $board->userId(),
            $board->name()
        );
    }
}