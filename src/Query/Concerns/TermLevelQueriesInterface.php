<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Concerns;

use Hypefactors\ElasticBuilder\Query\TermLevel\ExistsQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\FuzzyQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\IdsQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\PrefixQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\RangeQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\RegexpQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermsQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermsSetQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\WildcardQueryInterface;

interface TermLevelQueriesInterface
{
    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-exists-query.html
     */
    public function exists(callable | ExistsQueryInterface $value): self;

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-fuzzy-query.html
     */
    public function fuzzy(callable | FuzzyQueryInterface $value): self;

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-ids-query.html
     */
    public function ids(callable | IdsQueryInterface $value): self;

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-prefix-query.html
     */
    public function prefix(callable | PrefixQueryInterface $value): self;

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-range-query.html
     */
    public function range(callable | RangeQueryInterface $value): self;

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-regexp-query.html
     */
    public function regexp(callable | RegexpQueryInterface $value): self;

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-term-query.html
     */
    public function term(callable | TermQueryInterface $value): self;

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-terms-query.html
     */
    public function terms(callable | TermsQueryInterface $value): self;

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-terms-set-query.html
     */
    public function termsSet(callable | TermsSetQueryInterface $value): self;

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-wildcard-query.html
     */
    public function wildcard(callable | WildcardQueryInterface $value): self;
}
