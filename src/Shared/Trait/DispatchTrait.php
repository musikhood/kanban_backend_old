<?php

namespace App\Shared\Trait;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Throwable;

trait DispatchTrait
{
    use HandleTrait;

    /**
     * @throws Throwable
     */
    private function dispatch($message): mixed
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