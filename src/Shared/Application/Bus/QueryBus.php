<?php

namespace App\Shared\Application\Bus;

use App\Shared\Domain\Cqrs\QueryInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class QueryBus implements QueryBusInterface
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function handle(QueryInterface $query): mixed
    {
        return $this->handleQuery($query);
    }
}