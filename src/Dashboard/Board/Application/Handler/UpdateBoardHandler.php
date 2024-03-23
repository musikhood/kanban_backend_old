<?php

namespace App\Dashboard\Board\Application\Handler;

use App\Dashboard\Board\Application\Model\Command\UpdateBoardCommand;
use App\Dashboard\Board\Application\Service\BoardServiceInterface;
use App\Dashboard\Board\Domain\Repository\BoardRepositoryInterface;
use App\Shared\Application\Cqrs\CommandHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class UpdateBoardHandler implements CommandHandlerInterface
{
    public function __construct(
        private BoardServiceInterface $boardService,
        private BoardRepositoryInterface $boardRepository,
    )
    {
    }

    public function __invoke(UpdateBoardCommand $updateBoardCommand): void
    {
        $board = $this->boardService->findBoardEntity(
            $updateBoardCommand->getUserId(),
            $updateBoardCommand->getBoardId()
        );

        $board->rename($updateBoardCommand->getBoardName());

        $this->boardRepository->save($board);
    }
}