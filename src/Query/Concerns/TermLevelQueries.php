<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Concerns;

use Hypefactors\ElasticBuilder\Query\TermLevel\ExistsQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\ExistsQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\FuzzyQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\FuzzyQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\IdsQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\IdsQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\PrefixQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\PrefixQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\RangeQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\RangeQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\RegexpQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\RegexpQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermsQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermsQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermsSetQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermsSetQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\WildcardQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\WildcardQueryInterface;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/term-level-queries.html
 */
trait TermLevelQueries
{
    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-exists-query.html
     */
    public function exists(callable | ExistsQueryInterface $value): self
    {
        if (is_callable($value)) {
            $existsQuery = new ExistsQuery();

            $value($existsQuery);

            return $this->exists($existsQuery);
        }

        $this->body[] = $value;

        return $this;
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-fuzzy-query.html
     */
    public function fuzzy(callable | FuzzyQueryInterface $value): self
    {
        if (is_callable($value)) {
            $fuzzyQuery = new FuzzyQuery();

            $value($fuzzyQuery);

            return $this->fuzzy($fuzzyQuery);
        }

        $this->body[] = $value;

        return $this;
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-ids-query.html
     */
    public function ids(callable | IdsQueryInterface $value): self
    {
        if (is_callable($value)) {
            $idsQuery = new IdsQuery();

            $value($idsQuery);

            return $this->ids($idsQuery);
        }

        $this->body[] = $value;

        return $this;
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-prefix-query.html
     */
    public function prefix(callable | PrefixQueryInterface $value): self
    {
        if (is_callable($value)) {
            $prefixQuery = new PrefixQuery();

            $value($prefixQuery);

            return $this->prefix($prefixQuery);
        }

        $this->body[] = $value;

        return $this;
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-range-query.html
     */
    public function range(callable | RangeQueryInterface $value): self
    {
        if (is_callable($value)) {
            $rangeQuery = new RangeQuery();

            $value($rangeQuery);

            return $this->range($rangeQuery);
        }

        $this->body[] = $value;

        return $this;
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-regexp-query.html
     */
    public function regexp(callable | RegexpQueryInterface $value): self
    {
        if (is_callable($value)) {
            $regexpQuery = new RegexpQuery();

            $value($regexpQuery);

            return $this->regexp($regexpQuery);
        }

        $this->body[] = $value;

        return $this;
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-term-query.html
     */
    public function term(callable | TermQueryInterface $value): self
    {
        if (is_callable($value)) {
            $termQuery = new TermQuery();

            $value($termQuery);

            return $this->term($termQuery);
        }

        $this->body[] = $value;

        return $this;
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-terms-query.html
     */
    public function terms(callable | TermsQueryInterface $value): self
    {
        if (is_callable($value)) {
            $termsQuery = new TermsQuery();

            $value($termsQuery);

            return $this->terms($termsQuery);
        }

        $this->body[] = $value;

        return $this;
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-terms-set-query.html
     */
    public function termsSet(callable | TermsSetQueryInterface $value): self
    {
        if (is_callable($value)) {
            $termsSetQuery = new TermsSetQuery();

            $value($termsSetQuery);

            return $this->termsSet($termsSetQuery);
        }

        $this->body[] = $value;

        return $this;
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-wildcard-query.html
     */
    public function wildcard(callable | WildcardQueryInterface $value): self
    {
        if (is_callable($value)) {
            $wildcardQuery = new WildcardQuery();

            $value($wildcardQuery);

            return $this->wildcard($wildcardQuery);
        }

        $this->body[] = $value;

        return $this;
    }
}
