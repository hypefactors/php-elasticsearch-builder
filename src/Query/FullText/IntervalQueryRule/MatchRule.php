<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-intervals-query.html#intervals-match
 */
final class MatchRule extends Query
{
    public function query(string $query): self
    {
        $this->body['query'] = $query;

        return $this;
    }

    public function maxGaps(int $maxGaps): self
    {
        $this->body['max_gaps'] = $maxGaps;

        return $this;
    }

    public function ordered(bool $status): self
    {
        $this->body['ordered'] = $status;

        return $this;
    }

    public function analyzer(string $analyzer): self
    {
        $this->body['analyzer'] = $analyzer;

        return $this;
    }

    public function filter(callable | FilterRule $callable): self
    {
        if (is_callable($callable)) {
            $filterRule = new FilterRule();

            $callable($filterRule);

            $this->body += $filterRule->toArray();
        } else {
            $this->body += $callable->toArray();
        }

        return $this;
    }

    public function useField(string $useField): self
    {
        $this->body['use_field'] = $useField;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'match' => Util::recursivetoArray($this->body),
        ];
    }
}
