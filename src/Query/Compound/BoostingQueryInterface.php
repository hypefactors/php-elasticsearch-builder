<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Compound;

use Hypefactors\ElasticBuilder\Core\ArrayableInterface;
use Hypefactors\ElasticBuilder\Query\QueryInterface;

interface BoostingQueryInterface extends ArrayableInterface
{
    /**
     * Query you wish to run. Any returned documents must match this query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-boosting-query.html#boosting-top-level-params
     */
    public function positive(QueryInterface $query): BoostingQueryInterface;

    /**
     * Query used to decrease the relevance score of matching documents.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-boosting-query.html#boosting-top-level-params
     */
    public function negative(QueryInterface $query): BoostingQueryInterface;

    /**
     * Floating point number between 0 and 1.0 used to decrease the relevance scores of documents matching the negative query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-boosting-query.html#boosting-top-level-params
     */
    public function negativeBoost(int | float $factor): BoostingQueryInterface;
}
