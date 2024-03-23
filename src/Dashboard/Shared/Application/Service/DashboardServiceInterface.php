<?php

namespace App\Dashboard\Shared\Application\Service;

use App\Account\Domain\Entity\AccountId;
use App\Dashboard\User\Application\Dto\FindUserResponseDto;

interface DashboardServiceInterface
{
    public function findUser(): FindUserResponseDto;

}