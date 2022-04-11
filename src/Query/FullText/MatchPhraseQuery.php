<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText;

use Hypefactors\ElasticBuilder\Query\Query;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query-phrase.html
 */
class MatchPhraseQuery extends Query
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

    /**
     * Sets the query value to search with.
     *
     * @param mixed $query
     *
     * @return $this
     */
    public function query($query): self
    {
        $this->body['query'] = $query;

        return $this;
    }

    /**
     * Controls the maximum number of intervening unmatched positions permitted.
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
            'match_phrase' => [
                $this->field => $body,
            ],
        ];
    }
}
