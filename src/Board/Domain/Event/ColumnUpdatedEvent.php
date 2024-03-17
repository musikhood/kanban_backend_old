<?php

namespace App\Board\Domain\Event;

use App\Board\Domain\Entity\ColumnName;
use App\Shared\Domain\Event\DomainEventInterface;
use Symfony\Contracts\EventDispatcher\Event;

class ColumnUpdatedEvent extends Event implements DomainEventInterface
{
    private \DateTimeImmutable $occur;
    public function __construct(
        private readonly ColumnName $name,
    )
    {
        $this->occur = new \DateTimeImmutable();
    }

    public function getOccur(): \DateTimeImmutable
    {
        return $this->occur;
    }

    public function getColumnName(): ColumnName
    {
        return $this->name;
    }
}