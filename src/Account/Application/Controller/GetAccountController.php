<?php

namespace App\Account\Application\Controller;

use App\Account\Application\Model\Query\FindAccountQuery;
use App\Shared\Application\Bus\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Throwable;

class GetAccountController extends AbstractController
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly NormalizerInterface $normalizer
    ) {
    }

    /**
     * @throws Throwable
     */
    #[Route('/api/user/{userId}', name: 'app_get_user', methods: ['GET'])]
    public function index(string $userId): JsonResponse
    {
        $findUserQuery = new FindAccountQuery(
            $userId
        );

        $response = $this->queryBus->handle($findUserQuery);

        $response = $this->normalizer->normalize($response);

        return new JsonResponse($response);
    }
}