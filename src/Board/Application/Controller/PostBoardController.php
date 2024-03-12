<?php

namespace App\Board\Application\Controller;

use App\Board\Application\Model\Command\CreateBoardCommand;
use App\Shared\Application\Bus\CQBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class PostBoardController extends AbstractController
{
    public function __construct(
        private readonly CQBus $bus
    ) {
    }

    /**
     * @throws Throwable
     */
    #[Route('/api/board', name: 'app_post_board', methods: ['POST'])]
    public function index(#[MapRequestPayload] CreateBoardCommand $createBoardCommand): JsonResponse
    {
        $this->bus->dispatch($createBoardCommand);
        return new JsonResponse(['message'=>'created']);
    }
}