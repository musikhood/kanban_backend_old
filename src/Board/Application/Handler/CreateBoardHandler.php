<?php

namespace App\Board\Application\Handler;

use App\Board\Application\Model\Command\CreateBoardCommand;
use App\Board\Domain\Entity\Board;
use App\Board\Domain\RepositoryPort\BoardRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateBoardHandler
{
    public function __construct(
        private BoardRepositoryInterface $boardRepository,
        private EventDispatcherInterface $eventDispatcher
    )
    {
    }

    public function __invoke(CreateBoardCommand $createBoardCommand)
    {
        $board = Board::create($createBoardCommand->getName());

        $this->boardRepository->save($board);

        foreach ($board->pullDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
    }
}