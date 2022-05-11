<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Concerns\QueryBuilder;

use Hypefactors\ElasticBuilder\Query\FullText\MatchQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\RangeQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQueryInterface;
use Hypefactors\ElasticBuilder\QueryBuilderInterface;

interface LeafQueriesInterface
{
    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-match-query.html
     */
    public function match(callable | MatchQuery $value): QueryBuilderInterface;

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-range-query.html
     */
    public function range(callable | RangeQueryInterface $value): QueryBuilderInterface;

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-term-query.html
     */
    public function term(callable | TermQueryInterface $value): QueryBuilderInterface;
}
