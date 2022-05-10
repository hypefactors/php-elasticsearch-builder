<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-intervals-query.html#intervals-wildcard
 */
class WildcardRule extends Query
{
    // TODO: Disallow "boost" and "name" methods

    public function pattern(string $pattern): self
    {
        $this->body['pattern'] = $pattern;

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

    public function build(): array
    {
        return [
            'wildcard' => Util::recursivetoArray($this->body),
        ];
    }
}
