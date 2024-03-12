<?php

namespace App\Shared\Infrastructure\DoctrineTypes;

use App\Shared\Domain\ValueObject\UuidValueObject;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;


abstract class UuidType extends StringType
{
    abstract protected function typeClassName(): string;

    final public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        $className = $this->typeClassName();

        return new $className($value);
    }

    final public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        /** @var UuidValueObject $value */

        return $value instanceof UuidValueObject ? $value->getValue() : $value;
    }
}