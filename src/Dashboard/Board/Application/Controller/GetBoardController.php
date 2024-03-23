<?php

namespace App\Dashboard\Board\Application\Controller;

use App\Dashboard\Board\Application\Port\BoardServiceInterface;
use App\User\Domain\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class GetBoardController extends AbstractController
{
    public function __construct(
        private readonly BoardServiceInterface $boardService,
        private readonly NormalizerInterface $normalizer
    )
    {
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/board', name: 'app_get_board', methods: ['GET'])]
    public function index(): Response{
        /** @var User $user */
        $user = $this->getUser();

        $boards = $this->boardService->findBoard(
            $user->id()
        );

        $response = $this->normalizer->normalize($boards);

        return new JsonResponse($response);
    }
}