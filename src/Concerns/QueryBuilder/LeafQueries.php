<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Concerns\QueryBuilder;

use Hypefactors\ElasticBuilder\Query\FullText\MatchQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\RangeQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\RangeQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQueryInterface;
use Hypefactors\ElasticBuilder\QueryBuilderInterface;

trait LeafQueries
{
    public function match(callable | MatchQuery $value): QueryBuilderInterface
    {
        if (is_callable($value)) {
            $matchQuery = new MatchQuery();

            $value($matchQuery);

            return $this->match($matchQuery);
        }

        $this->queries += $value->build();

        return $this;
    }

    public function range(callable | RangeQueryInterface $value): QueryBuilderInterface
    {
        if (is_callable($value)) {
            $rangeQuery = new RangeQuery();

            $value($rangeQuery);

            return $this->range($rangeQuery);
        }

        $this->queries += $value->build();

        return $this;
    }

    public function term(callable | TermQueryInterface $value): QueryBuilderInterface
    {
        if (is_callable($value)) {
            $termQuery = new TermQuery();

            $value($termQuery);

            return $this->term($termQuery);
        }

        $this->queries += $value->build();

        return $this;
    }
}
