<?php

namespace App\Dashboard\User\Application\EventSubscriber;

use App\Account\Domain\Event\AccountCreatedEvent;
use App\Dashboard\User\Application\Model\Command\CreateUserCommand;
use App\Shared\Application\Bus\CommandBusInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class OnAccountCreated implements EventSubscriberInterface
{
    public function __construct(
        private CommandBusInterface $commandBus
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AccountCreatedEvent::class => 'createUser',
        ];
    }

    public function createUser(AccountCreatedEvent $accountCreatedEvent): void{
        $createUserCommand = new CreateUserCommand(
            $accountCreatedEvent->getAccountId()
        );

        $this->commandBus->dispatch($createUserCommand);
    }
}