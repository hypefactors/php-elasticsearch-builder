<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Span;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-span-or-query.html
 */
class SpanOrQuery extends Query implements SpanOrQueryInterface
{
    /**
     * The Span queries.
     */
    private array $queries = [];

    public function spanTerm(callable | SpanTermQueryInterface $value): SpanOrQueryInterface
    {
        if (is_callable($value)) {
            $spanTermQuery = new SpanTermQuery();

            $value($spanTermQuery);

            return $this->spanTerm($spanTermQuery);
        }

        $this->queries[] = $value;

        return $this;
    }

    public function spanNear(callable | SpanNearQueryInterface $value): SpanOrQueryInterface
    {
        if (is_callable($value)) {
            $spanNearQuery = new SpanNearQuery();

            $value($spanNearQuery);

            return $this->spanNear($spanNearQuery);
        }

        $this->queries[] = $value;

        return $this;
    }

    public function build(): array
    {
        $body = [];

        foreach ($this->queries as $query) {
            $body['clauses'][] = $query;
        }

        return [
            'span_or' => Util::recursivetoArray($body),
        ];
    }
}
