<?php

namespace App\User\Application\Controller;

use App\Shared\Domain\ValueObject\UserId;
use App\User\Application\Dto\FindUserRequestDto;
use App\User\Application\Port\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Throwable;

class GetUserController extends AbstractController
{
    public function __construct(
        private readonly UserServiceInterface $userService,
        private readonly NormalizerInterface $normalizer
    ) {
    }

    /**
     * @throws Throwable
     */
    #[Route('/api/user/{userId}', name: 'app_get_user', methods: ['GET'])]
    public function index(string $userId): JsonResponse
    {
        $user = $this->userService->findUser(
            new UserId($userId)
        );

        $response = $this->normalizer->normalize($user);

        return new JsonResponse($response);
    }
}