<?php

namespace App\Board\Application\Exception;

use App\Board\Application\Model\Query\FindBoardQuery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\WithHttpStatus;

#[WithHttpStatus(Response::HTTP_NOT_FOUND)]
class BoardNotFoundException extends \Exception
{
    public function __construct(
        private readonly FindBoardQuery $query
    )
    {
        parent::__construct('Board Not Found');
    }

    public function getQuery(): FindBoardQuery
    {
        return $this->query;
    }
}