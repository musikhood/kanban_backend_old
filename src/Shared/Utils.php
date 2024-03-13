<?php

namespace App\Shared;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Traversable;

class Utils
{
    public static function dateToString(DateTimeInterface $date): string
    {
        return $date->format(DateTimeInterface::ATOM);
    }

    /**
     * @throws Exception
     */
    public static function stringToDate(string $date): DateTimeImmutable
    {
        return new DateTimeImmutable($date);
    }


    public static function toSnakeCase(string $text): string
    {
        return ctype_lower($text) ? $text : strtolower((string) preg_replace('/([^A-Z\s])([A-Z])/', '$1_$2', $text));
    }

    public static function toCamelCase(string $text): string
    {
        return lcfirst(str_replace('_', '', ucwords($text, '_')));
    }

    public static function dot(array $array, string $prepend = ''): array
    {
        $results = [];
        foreach ($array as $key => $value) {
            if (is_array($value) && !empty($value)) {
                $results = array_merge($results, self::dot($value, $prepend . $key . '.'));
            } else {
                $results[$prepend . $key] = $value;
            }
        }

        return $results;
    }

    public static function iterableToArray(iterable $iterable): array
    {
        if (is_array($iterable)) {
            return $iterable;
        }

        return iterator_to_array($iterable);
    }


    private static function get_array($key, array $coll, $default)
    {
        return array_key_exists($key, $coll) ? $coll[$key] : $default;
    }

    private static function get_traversable($key, Traversable $coll, $default)
    {
        foreach ($coll as $k => $v) {
            if ($key == $k) {
                return $v;
            }
        }

        return $default;
    }
    public static function get($key, iterable $coll, $default = null)
    {
        return is_array($coll) ? self::get_array($key, $coll, $default) : self::get_traversable($key, $coll, $default);
    }
}