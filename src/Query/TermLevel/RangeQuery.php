<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Query;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-range-query.html
 */
class RangeQuery extends Query
{
    /**
     * The field to search on.
     *
     * @var string
     */
    protected $field;

    /**
     * Sets the field to search on.
     *
     * @param string $field
     *
     * @return $this
     */
    public function field(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Sets the "great than (gt)" range option for the given value.
     *
     * @param int|string $value
     *
     * @return $this
     */
    public function gt($value): self
    {
        $this->body['gt'] = $value;

        return $this;
    }

    /**
     * Proxy method for the "greater than (gt)" range option.
     *
     * @param int|string $value
     *
     * @return $this
     */
    public function greaterThan($value): self
    {
        return $this->gt($value);
    }

    /**
     * Sets the "greater than equals (gte)" range option for the given value.
     *
     * @param int|string $value
     *
     * @return $this
     */
    public function gte($value): self
    {
        $this->body['gte'] = $value;

        return $this;
    }

    /**
     * Proxy method for the "greater than equals (gte)" range option.
     *
     * @param int|string $value
     *
     * @return $this
     */
    public function greaterThanEquals($value): self
    {
        return $this->gte($value);
    }

    /**
     * Sets the "less than (gt)" range option for the given value.
     *
     * @param int|string $value
     *
     * @return $this
     */
    public function lt($value): self
    {
        $this->body['lt'] = $value;

        return $this;
    }

    /**
     * Proxy method for the "less than (lt)" range option.
     *
     * @param int|string $value
     *
     * @return $this
     */
    public function lessThan($value): self
    {
        return $this->lt($value);
    }

    /**
     * Sets the "less than equals (gt)" range option for the given value.
     *
     * @param int|string $value
     *
     * @return $this
     */
    public function lte($value): self
    {
        $this->body['lte'] = $value;

        return $this;
    }

    /**
     * Proxy method for the "less than equals (lte)" range option.
     *
     * @param int|string $value
     *
     * @return $this
     */
    public function lessThanEquals($value): self
    {
        return $this->lte($value);
    }

    /**
     * Sets the date format that will be used to convert date values in the query.
     *
     * @param string $format
     *
     * @return $this
     */
    public function format(string $format): self
    {
        $this->body['format'] = $format;

        return $this;
    }

    /**
     * Indicates how the range query matches values for range fields.
     *
     * @param string $relation
     *
     * @throws \InvalidArgumentException
     *
     * @return $this
     */
    public function relation(string $relation): self
    {
        $relationUpper = strtoupper($relation);

        $validRelations = ['INTERSECTS', 'CONTAINS', 'DISJOINT', 'WITHIN'];

        if (! in_array($relationUpper, $validRelations, true)) {
            throw new InvalidArgumentException("The [{$relation}] relation is invalid!");
        }

        $this->body['relation'] = $relationUpper;

        return $this;
    }

    /**
     * Sets the timezone that will be used to convert the date values in the query to UTC.
     *
     * @param string $timezone
     *
     * @return $this
     */
    public function timezone(string $timezone): self
    {
        $this->body['time_zone'] = $timezone;

        return $this;
    }

    /**
     * Returns the DSL Query as an array.
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function toArray(): array
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
