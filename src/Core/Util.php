<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Core;

use stdClass;

class Util
{
    public static function arrayWrap($values)
    {
        return ! is_array($values) ? [$values] : $values;
    }

    public static function recursivetoArray($values)
    {
        $values = array_map(function ($value) {
            if (is_object($value) && method_exists($value, 'build')) {
                return $value->build();
            }

            if (is_array($value)) {
                if (empty($value)) {
                    return new stdClass();
                }

                return static::recursivetoArray($value);
            }

            return $value;
        }, $values);

        // TODO: Determine if the "array_filter" causes problems or not ...
        return array_filter($values, function ($x) {
            return ! (is_null($x) || $x === 'false');
        });
    }
}
