<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Concerns\QueryBuilder;

use Hypefactors\ElasticBuilder\Query\Joining\NestedQueryInterface;
use Hypefactors\ElasticBuilder\QueryBuilderInterface;

interface JoiningQueriesInterface
{
    /**
     * Wraps another query to search nested fields.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-nested-query.html
     */
    public function nested(callable | NestedQueryInterface $value): QueryBuilderInterface;
}
