<?php

namespace App\User\Application\Controller;

use App\Shared\Application\Bus\CQBus;
use App\User\Application\Dto\CreateUserRequestDto;
use App\User\Application\Model\Command\CreateUserCommand;
use App\User\Application\Port\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Throwable;

class PostUserController extends AbstractController
{
    public function __construct(
        private readonly UserServiceInterface $userService,
        private readonly NormalizerInterface $normalizer
    ) {
    }

    /**
     * @throws Throwable
     */
    #[Route('/user', name: 'app_post_user', methods: ['POST'])]
    public function index(#[MapRequestPayload] CreateUserRequestDto $createUserRequestDto): JsonResponse
    {
        $response = $this->userService->createUser(
            $createUserRequestDto->getEmail(),
            $createUserRequestDto->getRoles(),
            $createUserRequestDto->getPassword()
        );

        $response = $this->normalizer->normalize($response);

        return new JsonResponse($response);
    }
}