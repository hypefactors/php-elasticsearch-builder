<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Compound;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;
use Hypefactors\ElasticBuilder\Query\QueryInterface;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-dis-max-query.html
 */
class DisjunctionMaxQuery extends Query implements DisjunctionMaxQueryInterface
{
    public function query(QueryInterface $query): DisjunctionMaxQueryInterface
    {
        $this->body['queries'][] = $query;

        return $this;
    }

    public function tieBreaker(float $factor): DisjunctionMaxQueryInterface
    {
        $this->body['tie_breaker'] = $factor;

        return $this;
    }

    public function build(): array
    {
        if (empty($this->body)) {
            return [];
        }

        return [
            'dis_max' => Util::recursivetoArray($this->body),
        ];
    }
}
