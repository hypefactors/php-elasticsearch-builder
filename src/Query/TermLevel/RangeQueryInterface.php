<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Core\ArrayableInterface;
use Hypefactors\ElasticBuilder\Query\QueryInterface;

interface RangeQueryInterface extends ArrayableInterface, QueryInterface
{
    /**
     * Sets the field to search on.
     */
    public function field(string $field): RangeQueryInterface;

    /**
     * Sets the "great than (gt)" range option for the given value.
     */
    public function gt(int | float | string $value): RangeQueryInterface;

    /**
     * Proxy method for the "greater than (gt)" range option.
     */
    public function greaterThan(int | float | string $value): RangeQueryInterface;

    /**
     * Sets the "greater than equals (gte)" range option for the given value.
     */
    public function gte(int | float | string $value): RangeQueryInterface;

    /**
     * Proxy method for the "greater than equals (gte)" range option.
     */
    public function greaterThanEquals(int | float | string $value): RangeQueryInterface;

    /**
     * Sets the "less than (gt)" range option for the given value.
     */
    public function lt(int | float | string $value): RangeQueryInterface;

    /**
     * Proxy method for the "less than (lt)" range option.
     */
    public function lessThan(int | float | string $value): RangeQueryInterface;

    /**
     * Sets the "less than equals (gt)" range option for the given value.
     */
    public function lte(int | float | string $value): RangeQueryInterface;

    /**
     * Proxy method for the "less than equals (lte)" range option.
     */
    public function lessThanEquals(int | float | string $value): RangeQueryInterface;

    /**
     * Sets the date format that will be used to convert date values in the query.
     */
    public function format(string $format): RangeQueryInterface;

    /**
     * Indicates how the range query matches values for range fields.
     *
     * @throws \InvalidArgumentException
     */
    public function relation(string $relation): RangeQueryInterface;

    /**
     * Sets the timezone that will be used to convert the date values in the query to UTC.
     */
    public function timezone(string $timezone): RangeQueryInterface;
}
