<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Compound;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;
use Hypefactors\ElasticBuilder\Query\QueryInterface;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-dis-max-query.html
 */
class DisMaxQuery extends Query
{
    public function tieBreaker($factor): self
    {
        $this->body['tie_breaker'] = $factor;

        return $this;
    }

    public function queries($queries): self
    {
        if (! isset($this->body['queries'])) {
            $this->body['queries'] = [];
        }

        foreach (Util::arrayWrap($queries) as $query) {
            $this->addQuery($query);
        }

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
            'dis_max' => Util::recursivetoArray($this->body),
        ];
    }

    protected function addQuery(QueryInterface $query): self
    {
        $this->body['queries'][] = $query;

        return $this;
    }
}
