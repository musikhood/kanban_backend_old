<?php

namespace App\Account\Application\Controller;

use App\Account\Application\Dto\CreateAccountRequestDto;
use App\Account\Application\Model\Command\CreateAccountCommand;
use App\Shared\Application\Bus\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class PostAccountController extends AbstractController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    /**
     * @throws Throwable
     */
    #[Route('/account', name: 'app_post_account', methods: ['POST'])]
    public function index(#[MapRequestPayload] CreateAccountRequestDto $createAccountRequestDto): JsonResponse
    {
        $createAccountCommand = new CreateAccountCommand(
            $createAccountRequestDto->getEmail(),
            $createAccountRequestDto->getRoles(),
            $createAccountRequestDto->getPassword()
        );

        $this->commandBus->dispatch($createAccountCommand);

        return new JsonResponse(['message'=>'Account created successfully']);
    }
}