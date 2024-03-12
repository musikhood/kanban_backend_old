<?php

namespace App\Shared\Application\Bus;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

class CQBus
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $messageBus
    )
    {
    }

    /**
     * @throws Throwable
     */
    public function dispatch($message): mixed
    {
        try {
            return $this->handle($message);
        } catch (HandlerFailedException $e) {
            while ($e instanceof HandlerFailedException) {
                $e = $e->getPrevious();
            }

            throw $e;
        }
    }
}