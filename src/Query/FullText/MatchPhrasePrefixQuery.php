<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText;

use Hypefactors\ElasticBuilder\Query\Query;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query-phrase-prefix.html
 */
class MatchPhrasePrefixQuery extends Query
{
    /**
     * The field to search on.
     *
     * @var string
     */
    protected $field;

    /**
     * Constructor.
     *
     * @param string|null $field
     * @param mixed       $query
     *
     * @return void
     */
    public function __construct(?string $field = null, $query = null)
    {
        $field && $this->field($field);

        $query && $this->query($query);
    }

    /**
     * Sets the field to search on.
     *
     * @param string $field
     *
     * @return $this
     */
    public function field(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function query($query): self
    {
        $this->body['query'] = $query;

        return $this;
    }

    /**
     * Analyzer used to convert text in the query value into tokens.
     *
     * @param string $analyzer
     *
     * @return $this
     */
    public function analyzer(string $analyzer): self
    {
        $this->body['analyzer'] = $analyzer;

        return $this;
    }

    /**
     * Maximum number of terms to which the last provided term of the query value will expand.
     *
     * @param int $maxExpansions
     *
     * @return $this
     */
    public function maxExpansions(int $maxExpansions): self
    {
        $this->body['max_expansions'] = $maxExpansions;

        return $this;
    }

    /**
     * Maximum number of positions allowed between matching tokens.
     *
     * @param int $slop
     *
     * @return $this
     */
    public function slop(int $slop): self
    {
        $this->body['slop'] = $slop;

        return $this;
    }

    /**
     * Indicates whether no documents are returned if the analyzer
     * removes all tokens, such as when using a stop filter.
     *
     * @param string $status
     *
     * @return $this
     */
    public function zeroTermsQuery(string $status): self
    {
        $statusLower = strtolower($status);

        $validStatuses = ['none', 'all'];

        if (! in_array($statusLower, $validStatuses, true)) {
            throw new InvalidArgumentException("The [{$status}] zero terms query status is invalid!");
        }

        $this->body['zero_terms_query'] = $status;

        return $this;
    }

    /**
     * Returns the DSL Query as an array.
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function toArray(): array
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
