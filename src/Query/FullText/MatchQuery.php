<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText;

use Hypefactors\ElasticBuilder\Query\Query;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query.html
 */
class MatchQuery extends Query
{
    /**
     * The field to search on.
     */
    private string | null $field = null;

    public function cutOffFrequency($frequency): self
    {
        $this->body['cutoff_frequency'] = $frequency;

        return $this;
    }

    /**
     * Sets the field to search on.
     *
     * @param string $field
     *
     * @return $this
     */
    public function field($field): self
    {
        $this->field = $field;

        return $this;
    }

    /**
     * The maximum edit distance.
     *
     * @param int|string $factor
     *
     * @return $this
     */
    public function fuzziness($factor): self
    {
        $this->body['fuzziness'] = $factor;

        return $this;
    }

    /**
     * The lenient parameter can be set to true to ignore exceptions caused by data-type
     * mismatches, such as trying to query a numeric field with a text query string.
     *
     * @param bool $status
     *
     * @return $this
     */
    public function lenient(bool $status): self
    {
        $this->body['lenient'] = $status;

        return $this;
    }

    /**
     * The maximum number of terms that the fuzzy query will expand to.
     *
     * @param int $limit
     *
     * @return $this
     */
    public function maxExpansions(int $limit): self
    {
        $this->body['max_expansions'] = $limit;

        return $this;
    }

    /**
     * Undocumented function.
     *
     * @param string $operator
     *
     * @throws \InvalidArgumentException
     *
     * @return $this
     */
    public function operator(string $operator): self
    {
        $operatorLower = strtolower($operator);

        $validOperators = ['and', 'or'];

        if (! in_array($operatorLower, $validOperators, true)) {
            throw new InvalidArgumentException("The [{$operator}] operator is invalid.");
        }

        $this->body['operator'] = $operatorLower;

        return $this;
    }

    /**
     * The number of initial characters which will not be "fuzzified".
     *
     * @param int $length
     *
     * @return $this
     */
    public function prefixLength(int $length): self
    {
        $this->body['prefix_length'] = $length;

        return $this;
    }

    public function query(array | string $query): self
    {
        $this->body['query'] = $query;

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
            'match' => [
                $this->field => $body,
            ],
        ];
    }
}
