<?php

namespace App\Dashboard\Shared\Application\Service;

use App\Dashboard\User\Application\Dto\FindUserResponseDto;

interface DashboardServiceInterface
{
    public function findUser(): FindUserResponseDto;

}