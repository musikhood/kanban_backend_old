<?php

namespace App\Dashboard\Board\Application\Controller;

use App\Account\Domain\Entity\Account;
use App\Dashboard\Board\Application\Model\Query\FindSingleBoardQuery;
use App\Dashboard\Board\Application\Port\BoardServiceInterface;
use App\Dashboard\Board\Domain\Entity\BoardId;
use App\Dashboard\User\Application\Dto\FindUserResponseDto;
use App\Dashboard\User\Application\Model\Query\FindUserQuery;
use App\Shared\Application\Bus\QueryBusInterface;
use App\User\Domain\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Throwable;

class GetSingleBoardController extends AbstractController
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly NormalizerInterface $normalizer,
    ) {
    }

    /**
     * @throws Throwable
     */
    #[Route('/api/board/{boardId}', name: 'app_get_single_board', methods: ['GET'])]
    public function index(string $boardId): JsonResponse
    {
        /** @var Account $account */
        $account = $this->getUser()->getAggregate();

        $findUserQuery = new FindUserQuery(
            $account->id()
        );

        /** @var FindUserResponseDto $userDto */
        $userDto = $this->queryBus->handle($findUserQuery);

        $findSingleBoardQuery = new FindSingleBoardQuery(
            new BoardId($boardId),
            $userDto->getId()
        );

        $board = $this->queryBus->handle($findSingleBoardQuery);

        $response = $this->normalizer->normalize($board);

        return new JsonResponse($response);
    }
}
