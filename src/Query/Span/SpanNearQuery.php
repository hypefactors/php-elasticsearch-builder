<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Span;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-span-near-query.html
 */
class SpanNearQuery extends Query implements SpanNearQueryInterface
{
    /**
     * The Span queries.
     */
    private array $queries = [];

    public function spanTerm(callable | SpanTermQueryInterface $value): SpanNearQueryInterface
    {
        if (is_callable($value)) {
            $spanTermQuery = new SpanTermQuery();

            $value($spanTermQuery);

            return $this->spanTerm($spanTermQuery);
        }

        $this->queries[] = $value;

        return $this;
    }

    public function spanOrQuery(callable | SpanOrQueryInterface $value): SpanNearQueryInterface
    {
        if (is_callable($value)) {
            $spanOrQuery = new SpanOrQuery();

            $value($spanOrQuery);

            return $this->spanOrQuery($spanOrQuery);
        }

        $this->queries[] = $value;

        return $this;
    }

    public function inOrder(bool $status): SpanNearQueryInterface
    {
        $this->body['in_order'] = $status;

        return $this;
    }

    public function slop(int $slop): SpanNearQueryInterface
    {
        $this->body['slop'] = $slop;

        return $this;
    }

    public function build(): array
    {
        $body = $this->body;

        foreach ($this->queries as $query) {
            $body['clauses'][] = $query;
        }

        return [
            'span_near' => Util::recursivetoArray($body),
        ];
    }
}
