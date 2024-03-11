<?php

namespace App\Board\Application\Exception;

use App\Board\Application\Model\Query\FindBoardQuery;

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