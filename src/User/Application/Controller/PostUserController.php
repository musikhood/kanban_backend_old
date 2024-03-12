<?php

namespace App\User\Application\Controller;

use App\Shared\Application\Bus\CQBus;
use App\User\Application\Model\Command\CreateUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class PostUserController extends AbstractController
{
    public function __construct(
        private readonly CQBus $bus
    ) {
    }

    /**
     * @throws Throwable
     */
    #[Route('/user', name: 'app_post_user', methods: ['POST'])]
    public function index(#[MapRequestPayload] CreateUserCommand $createUserCommand): JsonResponse
    {
        $this->bus->dispatch($createUserCommand);
        return new JsonResponse(['message'=>'created']);
    }
}