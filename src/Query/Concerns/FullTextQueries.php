<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Concerns;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQuery;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryInterface;
use Hypefactors\ElasticBuilder\Query\FullText\MatchPhrasePrefixQuery;
use Hypefactors\ElasticBuilder\Query\FullText\MatchPhraseQuery;
use Hypefactors\ElasticBuilder\Query\FullText\MatchQuery;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/full-text-queries.html
 */
trait FullTextQueries
{
    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-intervals-query.html
     */
    public function intervals(callable | IntervalsQueryInterface $value): self
    {
        if (is_callable($value)) {
            $intervalsQuery = new IntervalsQuery();

            $value($intervalsQuery);

            return $this->intervals($intervalsQuery);
        }

        if (! $value->isEmpty()) {
            $this->body[] = $value;
        }

        return $this;
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-match-query.html
     */
    public function match(callable | MatchQuery $value): self
    {
        if (is_callable($value)) {
            $matchQuery = new MatchQuery();

            $value($matchQuery);

            return $this->match($matchQuery);
        }

        if (! $value->isEmpty()) {
            $this->body[] = $value;
        }

        return $this;
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-match-query-phrase.html
     */
    public function matchPhrase(callable | MatchPhraseQuery $value): self
    {
        if (is_callable($value)) {
            $matchPhraseQuery = new MatchPhraseQuery();

            $value($matchPhraseQuery);

            return $this->matchPhrase($matchPhraseQuery);
        }

        $this->body[] = $value;

        return $this;
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-match-query-phrase-prefix.html
     */
    public function matchPhrasePrefix(callable | MatchPhrasePrefixQuery $value): self
    {
        if (is_callable($value)) {
            $matchPhrasePrefixQuery = new MatchPhrasePrefixQuery();

            $value($matchPhrasePrefixQuery);

            return $this->matchPhrasePrefix($matchPhrasePrefixQuery);
        }

        $this->body[] = $value;

        return $this;
    }
}
