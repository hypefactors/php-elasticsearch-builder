<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Compound;

use Hypefactors\ElasticBuilder\Core\ArrayableInterface;
use Hypefactors\ElasticBuilder\Query\QueryInterface;

interface DisjunctionMaxQueryInterface extends ArrayableInterface, QueryInterface
{
    /**
     * Add one query clause.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-dis-max-query.html#query-dsl-dis-max-query-top-level-params
     */
    public function query(QueryInterface $query): DisjunctionMaxQueryInterface;

    /**
     * Floating point number between 0 and 1.0 used to increase the relevance scores of documents matching multiple query clauses.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-dis-max-query.html#query-dsl-dis-max-query-top-level-params
     */
    public function tieBreaker(float $factor): DisjunctionMaxQueryInterface;
}
