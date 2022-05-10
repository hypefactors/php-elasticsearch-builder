<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Query;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-range-query.html
 */
class RangeQuery extends Query implements RangeQueryInterface
{
    /**
     * The field to search on.
     */
    private string | null $field = null;

    public function field(string $field): RangeQueryInterface
    {
        $this->field = $field;

        return $this;
    }

    public function gt(int | float | string $value): RangeQueryInterface
    {
        $this->body['gt'] = $value;

        return $this;
    }

    public function greaterThan(int | float | string $value): RangeQueryInterface
    {
        return $this->gt($value);
    }

    public function gte(int | float | string $value): RangeQueryInterface
    {
        $this->body['gte'] = $value;

        return $this;
    }

    public function greaterThanEquals(int | float | string $value): RangeQueryInterface
    {
        return $this->gte($value);
    }

    public function lt(int | float | string $value): RangeQueryInterface
    {
        $this->body['lt'] = $value;

        return $this;
    }

    public function lessThan(int | float | string $value): RangeQueryInterface
    {
        return $this->lt($value);
    }

    public function lte(int | float | string $value): RangeQueryInterface
    {
        $this->body['lte'] = $value;

        return $this;
    }

    public function lessThanEquals(int | float | string $value): RangeQueryInterface
    {
        return $this->lte($value);
    }

    public function format(string $format): RangeQueryInterface
    {
        $this->body['format'] = $format;

        return $this;
    }

    public function relation(string $relation): RangeQueryInterface
    {
        $relationUpper = strtoupper($relation);

        $validRelations = ['INTERSECTS', 'CONTAINS', 'DISJOINT', 'WITHIN'];

        if (! in_array($relationUpper, $validRelations, true)) {
            throw new InvalidArgumentException("The [{$relation}] relation is invalid!");
        }

        $this->body['relation'] = $relationUpper;

        return $this;
    }

    public function timezone(string $timezone): RangeQueryInterface
    {
        $this->body['time_zone'] = $timezone;

        return $this;
    }

    public function build(): array
    {
        if (! $this->field) {
            throw new InvalidArgumentException('The "field" is required!');
        }

        return [
            'range' => [
                $this->field => $this->body,
            ],
        ];
    }
}
