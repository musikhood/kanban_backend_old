<?php

namespace App\Shared\Infrastructure\DoctrineMappings;

use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Utils;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

abstract class UuidType extends StringType implements CustomTypeInterface
{
    abstract protected function typeClassName(): string;

    final public static function customTypeName(): string
    {
        $explode = explode('\\', static::class);
        return Utils::toSnakeCase(str_replace('Type', '', (string) end($explode)));
    }

    final public function getName(): string
    {
        return self::customTypeName();
    }

    final public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        $className = $this->typeClassName();

        return new $className($value);
    }

    final public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        /** @var Uuid $value */
        return $value->value();
    }
}