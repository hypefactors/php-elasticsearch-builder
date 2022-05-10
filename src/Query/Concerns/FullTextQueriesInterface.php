<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Concerns;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryInterface;
use Hypefactors\ElasticBuilder\Query\FullText\MatchPhrasePrefixQuery;
use Hypefactors\ElasticBuilder\Query\FullText\MatchPhraseQuery;
use Hypefactors\ElasticBuilder\Query\FullText\MatchQuery;

interface FullTextQueriesInterface
{
    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-intervals-query.html
     */
    public function intervals(callable | IntervalsQueryInterface $value): self;

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-match-query.html
     */
    public function match(callable | MatchQuery $value): self;

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-match-bool-prefix-query.html
     */

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-match-query-phrase.html
     */
    public function matchPhrase(callable | MatchPhraseQuery $value): self;

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-match-query-phrase-prefix.html
     */
    public function matchPhrasePrefix(callable | MatchPhrasePrefixQuery $value): self;

    /*
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-multi-match-query.html
     */

    /*
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-combined-fields-query.html
     */

    /*
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-query-string-query.html
     */

    /*
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-simple-query-string-query.html
     */
}
