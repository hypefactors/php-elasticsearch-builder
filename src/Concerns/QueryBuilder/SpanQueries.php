<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Concerns\QueryBuilder;

use Hypefactors\ElasticBuilder\Query\Span\SpanNearQuery;
use Hypefactors\ElasticBuilder\Query\Span\SpanNearQueryInterface;
use Hypefactors\ElasticBuilder\Query\Span\SpanOrQuery;
use Hypefactors\ElasticBuilder\Query\Span\SpanOrQueryInterface;
use Hypefactors\ElasticBuilder\Query\Span\SpanTermQuery;
use Hypefactors\ElasticBuilder\Query\Span\SpanTermQueryInterface;
use Hypefactors\ElasticBuilder\QueryBuilderInterface;
use RuntimeException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/span-queries.html
 */
trait SpanQueries
{
    public function spanContaining(callable | SpanContainingQueryInterface $value): QueryBuilderInterface
    {
        throw new RuntimeException('Not implemented!');
    }

    public function spanFieldMasking(callable | SpanFieldMaskingQueryInterface $value): QueryBuilderInterface
    {
        throw new RuntimeException('Not implemented!');
    }

    public function spanFirst(callable | SpanFirstQueryInterface $value): QueryBuilderInterface
    {
        throw new RuntimeException('Not implemented!');
    }

    public function spanMulti(callable | SpanMultiQueryInterface $value): QueryBuilderInterface
    {
        throw new RuntimeException('Not implemented!');
    }

    public function spanNear(callable | SpanNearQueryInterface $value): QueryBuilderInterface
    {
        if (is_callable($value)) {
            $spanNearQuery = new SpanNearQuery();

            $value($spanNearQuery);

            return $this->spanNear($spanNearQuery);
        }

        $this->body[] = $value;

        return $this;
    }

    public function spanNot(callable | SpanNotQueryInterface $value): QueryBuilderInterface
    {
        throw new RuntimeException('Not implemented!');
    }

    public function spanOr(callable | SpanOrQueryInterface $value): QueryBuilderInterface
    {
        if (is_callable($value)) {
            $spanOrQuery = new SpanOrQuery();

            $value($spanOrQuery);

            return $this->spanOr($spanOrQuery);
        }

        $this->body[] = $value;

        return $this;
    }

    public function spanTerm(callable | SpanTermQueryInterface $value): QueryBuilderInterface
    {
        if (is_callable($value)) {
            $spanTermQuery = new SpanTermQuery();

            $value($spanTermQuery);

            return $this->spanTerm($spanTermQuery);
        }

        $this->body[] = $value;

        return $this;
    }

    public function spanWithin(callable | SpanWithinQueryInterface $value): QueryBuilderInterface
    {
        throw new RuntimeException('Not implemented!');
    }
}
