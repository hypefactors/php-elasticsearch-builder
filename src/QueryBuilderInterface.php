<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder;

use Hypefactors\ElasticBuilder\Concerns\QueryBuilder\JoiningQueriesInterface;
use Hypefactors\ElasticBuilder\Concerns\QueryBuilder\LeafQueriesInterface;
use Hypefactors\ElasticBuilder\Concerns\QueryBuilder\SpanQueriesInterface;
use Hypefactors\ElasticBuilder\Core\ArrayableInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoostingQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\ConstantScoreQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\DisjunctionMaxQueryInterface;
use Hypefactors\ElasticBuilder\Query\MatchAllQueryInterface;
use Hypefactors\ElasticBuilder\Query\MatchNoneQueryInterface;

interface QueryBuilderInterface extends
    ArrayableInterface,
    JoiningQueriesInterface,
    LeafQueriesInterface,
    SpanQueriesInterface
{
    public function matchAll(callable | MatchAllQueryInterface $value): QueryBuilderInterface;

    public function matchNone(callable | MatchNoneQueryInterface $value): QueryBuilderInterface;

    public function bool(callable | BoolQueryInterface $value): QueryBuilderInterface;

    public function boosting(callable | BoostingQueryInterface $value): QueryBuilderInterface;

    public function constantScore(callable | ConstantScoreQueryInterface $value): QueryBuilderInterface;

    public function disjunctionMax(callable | DisjunctionMaxQueryInterface $value): QueryBuilderInterface;

    public function getQueries(): array;
}
