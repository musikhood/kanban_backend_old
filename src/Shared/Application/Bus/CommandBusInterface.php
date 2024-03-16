<?php

namespace App\Shared\Application\Bus;

use App\Shared\Domain\Cqrs\CommandInterface;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}