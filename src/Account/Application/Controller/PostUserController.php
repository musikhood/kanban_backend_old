<?php

namespace App\Account\Application\Controller;

use App\Account\Application\Dto\CreateUserRequestDto;
use App\Account\Application\Model\Command\CreateUserCommand;
use App\Shared\Application\Bus\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class PostUserController extends AbstractController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    /**
     * @throws Throwable
     */
    #[Route('/user', name: 'app_post_user', methods: ['POST'])]
    public function index(#[MapRequestPayload] CreateUserRequestDto $createUserRequestDto): JsonResponse
    {
        $createUserCommand = new CreateUserCommand(
            $createUserRequestDto->getEmail(),
            $createUserRequestDto->getRoles(),
            $createUserRequestDto->getPassword()
        );

        $this->commandBus->dispatch($createUserCommand);

        return new JsonResponse(['message'=>'User created successfully']);
    }
}