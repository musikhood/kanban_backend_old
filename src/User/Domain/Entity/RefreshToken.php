<?php

namespace App\User\Domain\Entity;

use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshToken as BaseRefreshToken;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "refresh_tokens")]
class RefreshToken extends BaseRefreshToken
{
}
