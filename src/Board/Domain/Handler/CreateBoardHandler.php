<?php

namespace App\Board\Domain\Handler;

use App\Board\Domain\Entity\Board;
use App\Board\Domain\Entity\BoardName;
use App\Board\Domain\Model\Command\CreateBoardCommand;
use App\Board\Domain\RepositoryPort\BoardRepositoryInterface;
use App\Shared\Domain\Cqrs\CommandHandlerInterface;
use App\User\Application\Port\UserServiceInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateBoardHandler implements CommandHandlerInterface
{
    public function __construct(
        private BoardRepositoryInterface $boardRepository,
        private EventDispatcherInterface $eventDispatcher,
        private UserServiceInterface $userService
    )
    {
    }

    public function __invoke(CreateBoardCommand $createBoardCommand): void
    {

        $user = $this->userService->findUserEntity($createBoardCommand->getUserId());

        $board = Board::create(
            $user,
            new BoardName($createBoardCommand->getName())
        );

        $this->boardRepository->save($board);

        foreach ($board->pullDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
    }
}