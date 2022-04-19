<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\AllOfRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\AnyOfRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FuzzyRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\MatchRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\PrefixRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\WildcardRule;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-intervals-query.html
 */
final class IntervalsQuery extends Query
{
    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-intervals-query.html#intervals-match
     */
    public function match(callable | MatchRule $callable): self
    {
        if (is_callable($callable)) {
            $matchRule = new MatchRule();

            $callable($matchRule);

            $this->body[] = $matchRule->toArray();
        } else {
            $this->body[] = $callable->toArray();
        }

        return $this;
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-intervals-query.html#intervals-prefix
     */
    public function prefix(callable | PrefixRule $callable): self
    {
        if (is_callable($callable)) {
            $prefixRule = new PrefixRule();

            $callable($prefixRule);

            $this->body[] = $prefixRule;
        } else {
            $this->body[] = $callable;
        }

        return $this;
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-intervals-query.html#intervals-wildcard
     */
    public function wildcard(callable | WildcardRule $callable): self
    {
        if (is_callable($callable)) {
            $wildcardRule = new WildcardRule();

            $callable($wildcardRule);

            $this->body[] = $wildcardRule;
        } else {
            $this->body[] = $callable;
        }

        return $this;
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-intervals-query.html#intervals-fuzzy
     */
    public function fuzzy(callable | FuzzyRule $callable): self
    {
        if (is_callable($callable)) {
            $fuzzyRule = new FuzzyRule();

            $callable($fuzzyRule);

            $this->body[] = $fuzzyRule;
        } else {
            $this->body[] = $callable;
        }

        return $this;
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-intervals-query.html#intervals-all_of
     */
    public function allOf(callable | AllOfRule $callable): self
    {
        if (is_callable($callable)) {
            $allOfRule = new AllOfRule();

            $callable($allOfRule);

            $this->body[] = $allOfRule;
        } else {
            $this->body[] = $callable;
        }

        return $this;
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-intervals-query.html#intervals-any_of
     */
    public function anyOf(callable | AnyOfRule $callable): self
    {
        if (is_callable($callable)) {
            $anyOfRule = new AnyOfRule();

            $callable($anyOfRule);

            $this->body[] = $anyOfRule;
        } else {
            $this->body[] = $callable;
        }

        return $this;
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-intervals-query.html#intervals-filter
     */
    public function filter(callable | FilterRule $callable): self
    {
        if (is_callable($callable)) {
            $filterRule = new FilterRule();

            $callable($filterRule);

            $this->body[] = $filterRule;
        } else {
            $this->body[] = $callable;
        }

        return $this;
    }

    /**
     * Returns the DSL Query as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'intervals' => Util::recursivetoArray($this->body),
        ];
    }
}
