<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText;

use Hypefactors\ElasticBuilder\Query\Query;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query-phrase-prefix.html
 */
class MatchPhrasePrefixQuery extends Query implements MatchPhrasePrefixQueryInterface
{
    /**
     * The field to search on.
     */
    private string | null $field = null;

    public function field(string $field): MatchPhrasePrefixQueryInterface
    {
        $this->field = $field;

        return $this;
    }

    public function query($query): MatchPhrasePrefixQueryInterface
    {
        $this->body['query'] = $query;

        return $this;
    }

    public function analyzer(string $analyzer): MatchPhrasePrefixQueryInterface
    {
        $this->body['analyzer'] = $analyzer;

        return $this;
    }

    public function maxExpansions(int $maxExpansions): MatchPhrasePrefixQueryInterface
    {
        $this->body['max_expansions'] = $maxExpansions;

        return $this;
    }

    public function slop(int $slop): MatchPhrasePrefixQueryInterface
    {
        $this->body['slop'] = $slop;

        return $this;
    }

    public function zeroTermsQuery(string $status): MatchPhrasePrefixQueryInterface
    {
        $statusLower = strtolower($status);

        $validStatuses = ['none', 'all'];

        if (! in_array($statusLower, $validStatuses, true)) {
            throw new InvalidArgumentException("The [{$status}] zero terms query status is invalid!");
        }

        $this->body['zero_terms_query'] = $status;

        return $this;
    }

    public function build(): array
    {
        if (! $this->field) {
            throw new InvalidArgumentException('The "field" is required!');
        }

        if (! isset($this->body['query'])) {
            throw new InvalidArgumentException('The "query" is required!');
        }

        $body = $this->body;

        if (count($body) === 1) {
            $body = $body['query'];
        }

        return [
            'match_phrase_prefix' => [
                $this->field => $body,
            ],
        ];
    }
}
