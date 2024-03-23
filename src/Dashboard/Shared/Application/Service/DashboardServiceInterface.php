<?php

namespace App\Dashboard\Shared\Application\Service;

use App\Dashboard\User\Application\Dto\UserDto;

interface DashboardServiceInterface
{
    public function findUser(): UserDto;

}