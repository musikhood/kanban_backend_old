<?php

namespace App\User\Application\Controller;

use App\User\Application\Model\Command\CreateUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class PostUserController extends AbstractController
{
    use HandleTrait;
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
    }

    #[Route('/api/user', name: 'app_post_user', methods: ['POST'])]
    public function index(#[MapRequestPayload] CreateUserCommand $createUserCommand): JsonResponse
    {
        $this->handle($createUserCommand);
        return new JsonResponse(['message'=>'created']);
    }
}