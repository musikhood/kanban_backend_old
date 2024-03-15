<?php

namespace App\Board\Domain\Entity;

use App\Shared\Domain\ValueObject\StringValueObject;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class BoardName extends StringValueObject
{
    #[ORM\Column(name: 'name', type: 'string')]
    protected string $value;
}