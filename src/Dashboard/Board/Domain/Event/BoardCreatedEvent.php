<?php

namespace App\Dashboard\Board\Domain\Event;

use App\Dashboard\Board\Domain\Entity\ValueObject\BoardName;
use App\Shared\Domain\Event\DomainEventInterface;
use Symfony\Contracts\EventDispatcher\Event;

class BoardCreatedEvent extends Event implements DomainEventInterface
{
    private \DateTimeImmutable $occur;
    public function __construct(
        private readonly BoardName $name,
    )
    {
        $this->occur = new \DateTimeImmutable();
    }

    public function getOccur(): \DateTimeImmutable
    {
        return $this->occur;
    }

    public function getBoardName(): BoardName
    {
        return $this->name;
    }

}