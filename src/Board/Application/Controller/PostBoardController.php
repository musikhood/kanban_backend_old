<?php

namespace App\Board\Application\Controller;

use App\Board\Application\Model\Command\CreateBoardCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class PostBoardController extends AbstractController
{
    use HandleTrait;
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
    }

    #[Route('/api/board', name: 'app_post_board', methods: ['POST'])]
    public function index(#[MapRequestPayload] CreateBoardCommand $createBoardCommand): JsonResponse
    {
        $this->handle($createBoardCommand);
        return new JsonResponse(['message'=>'created']);
    }
}