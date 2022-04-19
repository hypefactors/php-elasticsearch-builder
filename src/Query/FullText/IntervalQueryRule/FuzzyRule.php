<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-intervals-query.html#intervals-fuzzy
 */
final class FuzzyRule extends Query
{
    public function term(string $term): self
    {
        $this->body['term'] = $term;

        return $this;
    }

    public function prefixLength(int $length): self
    {
        $this->body['prefix_length'] = $length;

        return $this;
    }

    public function transpositions(bool $status): self
    {
        $this->body['transpositions'] = $status;

        return $this;
    }

    public function analyzer(string $analyzer): self
    {
        $this->body['analyzer'] = $analyzer;

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
            'fuzzy' => Util::recursivetoArray($this->body),
        ];
    }
}
