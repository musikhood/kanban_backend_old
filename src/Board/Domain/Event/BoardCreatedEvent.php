<?php

namespace App\Board\Domain\Event;

use App\Board\Application\Model\Command\CreateBoardCommand;
use App\Shared\Event\DomainEventInterface;
use Symfony\Contracts\EventDispatcher\Event;

class BoardCreatedEvent extends Event implements DomainEventInterface
{
    private \DateTimeImmutable $occur;
    public function __construct(
        private readonly CreateBoardCommand $createBoardCommand,
    )
    {
        $this->occur = new \DateTimeImmutable();
    }

    public function getCreateBoardCommand(): CreateBoardCommand
    {
        return $this->createBoardCommand;
    }

    public function getOccur(): \DateTimeImmutable
    {
        return $this->occur;
    }
}