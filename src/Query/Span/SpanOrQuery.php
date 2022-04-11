<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Span;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-or-query.html
 */
class SpanOrQuery extends Query implements SpanQueryInterface
{
    /**
     * The Span queries.
     *
     * @var array
     */
    protected $queries = [];

    /**
     * Adds a Span Query.
     *
     * @param \Hypefactors\ElasticBuilder\Query\Span\SpanQueryInterface $query
     *
     * @return $this
     */
    public function addQuery(SpanQueryInterface $query): self
    {
        $this->queries[] = $query;

        return $this;
    }

    /**
     * Returns the DSL Query as an array.
     *
     * @return array
     */
    public function toArray(): array
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
