<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Compound;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;
use Hypefactors\ElasticBuilder\Query\QueryInterface;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-constant-score-query.html
 */
class ConstantScoreQuery extends Query
{
    public function filter(QueryInterface $query): self
    {
        $this->body['filter'] = $query;

        return $this;
    }

    /**
     * Returns the DSL Query as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'constant_score' => Util::recursivetoArray($this->body),
        ];
    }
}
