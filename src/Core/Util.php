<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Core;

use stdClass;

final class Util
{
    public static function arrayWrap($values)
    {
        return ! is_array($values) ? [$values] : $values;
    }

    public static function recursivetoArray($values)
    {
        return array_map(function ($value) {
            if (is_object($value) && method_exists($value, 'toArray')) {
                return $value->toArray();
            }

            if (is_array($value)) {
                if (empty($value)) {
                    return new stdClass();
                }

                return static::recursivetoArray($value);
            }

            return $value;
        }, $values);
    }
}
