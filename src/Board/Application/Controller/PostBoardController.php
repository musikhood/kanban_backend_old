<?php

namespace App\Board\Application\Controller;

use App\Board\Application\Model\Command\CreateBoardCommand;
use App\Shared\Trait\DispatchTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class PostBoardController extends AbstractController
{
    use DispatchTrait;
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
    }

    /**
     * @throws Throwable
     */
    #[Route('/api/board', name: 'app_post_board', methods: ['POST'])]
    public function index(#[MapRequestPayload] CreateBoardCommand $createBoardCommand): JsonResponse
    {
        $this->dispatch($createBoardCommand);
        return new JsonResponse(['message'=>'created']);
    }
}