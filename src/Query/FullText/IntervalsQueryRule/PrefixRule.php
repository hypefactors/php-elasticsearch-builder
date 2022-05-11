<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-intervals-query.html#intervals-prefix
 */
class PrefixRule extends Query
{
    // TODO: Disallow "boost" and "name" methods

    public function prefix(string $prefix): self
    {
        $this->body['prefix'] = $prefix;

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
            'prefix' => Util::recursivetoArray($this->body),
        ];
    }
}
