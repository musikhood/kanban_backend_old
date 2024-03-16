<?php

namespace App\Shared\Application\Bus;

use App\Shared\Domain\Cqrs\QueryInterface;

interface QueryBusInterface
{
    public function handle(QueryInterface $query): mixed;
}