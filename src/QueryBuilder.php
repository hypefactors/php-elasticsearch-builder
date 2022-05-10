<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder;

use Hypefactors\ElasticBuilder\Concerns\QueryBuilder\JoiningQueries;
use Hypefactors\ElasticBuilder\Concerns\QueryBuilder\LeafQueries;
use Hypefactors\ElasticBuilder\Concerns\QueryBuilder\SpanQueries;
use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoostingQuery;
use Hypefactors\ElasticBuilder\Query\Compound\BoostingQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\ConstantScoreQuery;
use Hypefactors\ElasticBuilder\Query\Compound\ConstantScoreQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\DisjunctionMaxQuery;
use Hypefactors\ElasticBuilder\Query\Compound\DisjunctionMaxQueryInterface;
use Hypefactors\ElasticBuilder\Query\MatchAllQuery;
use Hypefactors\ElasticBuilder\Query\MatchAllQueryInterface;
use Hypefactors\ElasticBuilder\Query\MatchNoneQuery;
use Hypefactors\ElasticBuilder\Query\MatchNoneQueryInterface;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl.html
 */
class QueryBuilder implements QueryBuilderInterface
{
    use JoiningQueries;
    use LeafQueries;
    use SpanQueries;

    private array $queries = [];

    public function matchAll(callable | MatchAllQueryInterface $value): QueryBuilderInterface
    {
        if (is_callable($value)) {
            $matchAllQuery = new MatchAllQuery();

            $value($matchAllQuery);

            return $this->matchAll($matchAllQuery);
        }

        $this->queries['match_all'] = $value;

        return $this;
    }

    public function matchNone(callable | MatchNoneQueryInterface $value): QueryBuilderInterface
    {
        if (is_callable($value)) {
            $matchNoneQuery = new MatchNoneQuery();

            $value($matchNoneQuery);

            return $this->matchNone($matchNoneQuery);
        }

        $this->queries['match_none'] = $value;

        return $this;
    }

    public function bool(callable | BoolQueryInterface $value): QueryBuilderInterface
    {
        if (is_callable($value)) {
            $boolQuery = new BoolQuery();

            $value($boolQuery);

            return $this->bool($boolQuery);
        }

        if (! $value->isEmpty()) {
            $this->queries['bool'] = $value;
        }

        return $this;
    }

    public function boosting(callable | BoostingQueryInterface $value): QueryBuilderInterface
    {
        if (is_callable($value)) {
            $boostingQuery = new BoostingQuery();

            $value($boostingQuery);

            return $this->boosting($boostingQuery);
        }

        if (! $value->isEmpty()) {
            $this->queries['boosting'] = $value;
        }

        return $this;
    }

    public function constantScore(callable | ConstantScoreQueryInterface $value): QueryBuilderInterface
    {
        if (is_callable($value)) {
            $constantScoreQuery = new ConstantScoreQuery();

            $value($constantScoreQuery);

            return $this->constantScore($constantScoreQuery);
        }

        if (! $value->isEmpty()) {
            $this->queries['constant_score'] = $value;
        }

        return $this;
    }

    public function disjunctionMax(callable | DisjunctionMaxQueryInterface $value): QueryBuilderInterface
    {
        if (is_callable($value)) {
            $disjunctionMaxQuery = new DisjunctionMaxQuery();

            $value($disjunctionMaxQuery);

            return $this->disjunctionMax($disjunctionMaxQuery);
        }

        if (! $value->isEmpty()) {
            $this->queries['dis_max'] = $value;
        }

        return $this;
    }

    public function isEmpty(): bool
    {
        return empty($this->queries);
    }

    public function getQueries(): array
    {
        return $this->queries;
    }

    public function build(): array
    {
        if (count($this->queries) === 0) {
            return [];
        }

        $queries = [];

        foreach ($this->queries as $query) {
            $queries += $query->build();
        }

        return Util::recursivetoArray($queries);
    }
}
