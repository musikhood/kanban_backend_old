<?php

namespace App\Board\Application\Controller;

use App\Board\Application\Model\Query\FindBoardQuery;
use App\Board\Domain\Entity\Board;
use App\Shared\Application\Bus\CQBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class GetBoardController extends AbstractController
{
    public function __construct(
        private readonly CQBus $bus
    ) {
    }

    /**
     * @throws Throwable
     */
    #[Route('/api/board', name: 'app_get_board', methods: ['GET'])]
    public function index(#[MapQueryString] FindBoardQuery $findBoardQuery): JsonResponse
    {
        /** @var Board $board */
        $board = $this->bus->dispatch($findBoardQuery);
        return new JsonResponse($board->toArray());
    }
}
