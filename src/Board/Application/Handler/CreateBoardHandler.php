<?php

namespace App\Board\Application\Handler;

use App\Board\Application\Model\Command\CreateBoardCommand;
use App\Board\Domain\Entity\Board;
use App\Board\Domain\Entity\BoardId;
use App\Board\Domain\Entity\BoardName;
use App\Board\Domain\RepositoryPort\BoardRepositoryInterface;
use App\Shared\Domain\Entity\UserId;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateBoardHandler
{
    public function __construct(
        private BoardRepositoryInterface $boardRepository,
        private EventDispatcherInterface $eventDispatcher,
        private Security $security
    )
    {
    }

    public function __invoke(CreateBoardCommand $createBoardCommand): void
    {
        $board = Board::create(
            new BoardId(Uuid::uuid4()->toString()),
            new UserId($this->security->getUser()->getId()->getValue()),
            new BoardName($createBoardCommand->getName())
        );

        $this->boardRepository->save($board);

        foreach ($board->pullDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
    }
}