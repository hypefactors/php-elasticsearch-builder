<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText;

use Hypefactors\ElasticBuilder\Core\ArrayableInterface;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\AllOfRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\AnyOfRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FuzzyRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\MatchRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\PrefixRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\WildcardRule;
use Hypefactors\ElasticBuilder\Query\QueryInterface;

interface IntervalsQueryInterface extends ArrayableInterface, QueryInterface
{
    /**
     * Sets the field to search on.
     */
    public function field(string $field): IntervalsQueryInterface;

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-intervals-query.html#intervals-match
     */
    public function match(callable | MatchRule $value): IntervalsQueryInterface;

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-intervals-query.html#intervals-prefix
     */
    public function prefix(callable | PrefixRule $callable): IntervalsQueryInterface;

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-intervals-query.html#intervals-wildcard
     */
    public function wildcard(callable | WildcardRule $callable): IntervalsQueryInterface;

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-intervals-query.html#intervals-fuzzy
     */
    public function fuzzy(callable | FuzzyRule $callable): IntervalsQueryInterface;

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-intervals-query.html#intervals-all_of
     */
    public function allOf(callable | AllOfRule $callable): IntervalsQueryInterface;

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-intervals-query.html#intervals-any_of
     */
    public function anyOf(callable | AnyOfRule $callable): IntervalsQueryInterface;
}
