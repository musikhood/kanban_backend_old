<?php

namespace App\Board\Application\Controller;

use App\Board\Application\Model\Query\FindBoardQuery;
use App\Board\Domain\Entity\Board;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
class GetBoardController extends AbstractController
{
    use HandleTrait;
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
    }

    #[Route('/api/board', name: 'app_get_board', methods: ['GET'])]
    public function index(#[MapQueryString] FindBoardQuery $findBoardQuery): JsonResponse
    {
        /** @var Board $board */
        $board = $this->handle($findBoardQuery);
        return new JsonResponse($board->toArray());
    }
}
