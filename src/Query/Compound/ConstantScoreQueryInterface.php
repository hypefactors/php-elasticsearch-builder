<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Compound;

use Hypefactors\ElasticBuilder\Core\ArrayableInterface;
use Hypefactors\ElasticBuilder\Query\QueryInterface;

interface ConstantScoreQueryInterface extends ArrayableInterface, QueryInterface
{
    /**
     * Filter query you wish to run. Any returned documents must match this query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-constant-score-query.html#constant-score-top-level-params
     */
    public function filter(QueryInterface $query): ConstantScoreQueryInterface;
}
