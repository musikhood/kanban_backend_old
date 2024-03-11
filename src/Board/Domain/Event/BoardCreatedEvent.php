<?php

namespace App\Board\Domain\Event;

use App\Shared\Event\DomainEventInterface;
use Symfony\Contracts\EventDispatcher\Event;

class BoardCreatedEvent extends Event implements DomainEventInterface
{
    private \DateTimeImmutable $occur;
    public function __construct(
        private readonly string $name,
    )
    {
        $this->occur = new \DateTimeImmutable();
    }

    public function getOccur(): \DateTimeImmutable
    {
        return $this->occur;
    }

    public function getName(): string
    {
        return $this->name;
    }

}