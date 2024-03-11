<?php

namespace App\User\Application\Controller;

use App\Shared\Trait\DispatchTrait;
use App\User\Application\Model\Command\CreateUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class PostUserController extends AbstractController
{
    use DispatchTrait;
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
    }

    /**
     * @throws Throwable
     */
    #[Route('/api/user', name: 'app_post_user', methods: ['POST'])]
    public function index(#[MapRequestPayload] CreateUserCommand $createUserCommand): JsonResponse
    {
        $this->dispatch($createUserCommand);
        return new JsonResponse(['message'=>'created']);
    }
}