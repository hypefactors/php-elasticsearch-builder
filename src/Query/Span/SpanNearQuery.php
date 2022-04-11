<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Span;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-near-query.html
 */
class SpanNearQuery extends Query implements SpanQueryInterface
{
    /**
     * The Span queries.
     *
     * @var array
     */
    protected $queries = [];

    /**
     * Determines wether matches are required to be in-order.
     *
     * @param bool $status
     *
     * @return $this
     */
    public function inOrder(bool $status): self
    {
        $this->body['in_order'] = $status;

        return $this;
    }

    /**
     * Controls the maximum number of intervening unmatched positions permitted.
     *
     * @param int $slop
     *
     * @return $this
     */
    public function slop(int $slop): self
    {
        $this->body['slop'] = $slop;

        return $this;
    }

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
        $body = $this->body;

        foreach ($this->queries as $query) {
            $body['clauses'][] = $query;
        }

        return [
            'span_near' => Util::recursivetoArray($body),
        ];
    }
}
