<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Concerns\QueryBuilder;

use Hypefactors\ElasticBuilder\Query\Span\SpanNearQueryInterface;
use Hypefactors\ElasticBuilder\Query\Span\SpanOrQueryInterface;
use Hypefactors\ElasticBuilder\Query\Span\SpanTermQueryInterface;
use Hypefactors\ElasticBuilder\QueryBuilderInterface;

interface SpanQueriesInterface
{
    /**
     * Accepts a list of span queries, but only returns those spans which also match a second span query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-span-containing-query.html
     */
    public function spanContaining(callable | SpanContainingQueryInterface $value): QueryBuilderInterface;

    /**
     * Allows queries like span-near or span-or across different fields.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-span-field-masking-query.html
     */
    public function spanFieldMasking(callable | SpanFieldMaskingQueryInterface $value): QueryBuilderInterface;

    /**
     * Accepts another span query whose matches must appear within the first N positions of the field.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-span-first-query.html
     */
    public function spanFirst(callable | SpanFirstQueryInterface $value): QueryBuilderInterface;

    /**
     * Wraps a term, range, prefix, wildcard, regexp, or fuzzy query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-span-multi-term-query.html
     */
    public function spanMulti(callable | SpanMultiQueryInterface $value): QueryBuilderInterface;

    /**
     * Accepts multiple span queries whose matches must be within the specified distance of each other, and possibly in the same order.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-span-near-query.html
     */
    public function spanNear(callable | SpanNearQueryInterface $value): QueryBuilderInterface;

    /**
     * Wraps another span query, and excludes any documents which match that query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-span-not-query.html
     */
    public function spanNot(callable | SpanNotQueryInterface $value): QueryBuilderInterface;

    /**
     * Combines multiple span queries — returns documents which match any of the specified queries.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-span-or-query.html
     */
    public function spanOr(callable | SpanOrQueryInterface $value): QueryBuilderInterface;

    /**
     * The equivalent of the term query but for use with other span queries.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-span-term-query.html
     */
    public function spanTerm(callable | SpanTermQueryInterface $value): QueryBuilderInterface;

    /**
     * The result from a single span query is returned as long is its span falls within the spans returned by a list of other span queries.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-span-within-query.html
     */
    public function spanWithin(callable | SpanWithinQueryInterface $value): QueryBuilderInterface;
}
