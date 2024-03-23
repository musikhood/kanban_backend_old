<?php

namespace App\Shared\Application\Bus;

use App\Shared\Application\Cqrs\CommandInterface;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}