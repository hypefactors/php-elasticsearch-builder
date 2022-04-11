<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query;

interface QueryInterface
{
    /**
     * Sets the boost value to increase or decrease the relevance scores of this query.
     *
     * @param float $factor
     *
     * @return \Hypefactors\ElasticBuilder\Query\QueryInterface
     */
    public function boost(float $factor): QueryInterface;

    /**
     * Sets the query name.
     *
     * @param string $name
     *
     * @return \Hypefactors\ElasticBuilder\Query\QueryInterface
     */
    public function name(string $name): QueryInterface;

    /**
     * Returns the DSL Query as an array.
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Returns the query in JSON format.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson(int $options = 0): string;
}
