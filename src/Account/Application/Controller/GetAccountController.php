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
    #[Route('/api/account/{accountId}', name: 'app_get_account', methods: ['GET'])]
    public function index(string $accountId): JsonResponse
    {
        $findAccountQuery = new FindAccountQuery(
            $accountId
        );

        $response = $this->queryBus->handle($findAccountQuery);

        $response = $this->normalizer->normalize($response);

        return new JsonResponse($response);
    }
}