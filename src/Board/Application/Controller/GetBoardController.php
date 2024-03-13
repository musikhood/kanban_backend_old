<?php

namespace App\Board\Application\Controller;

use App\Board\Application\Model\Query\FindBoardQuery;
use App\Board\Domain\Entity\Board;
use App\Shared\Application\Bus\CQBus;
use App\Shared\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
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

        $data = [
            'name' => $board->name()->getValue(),
            'author' => $board->user()->getValue()
        ];

        return new JsonResponse($data);
    }
}
