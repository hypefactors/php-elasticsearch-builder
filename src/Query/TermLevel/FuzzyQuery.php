<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Query;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-fuzzy-query.html
 */
class FuzzyQuery extends Query
{
    /**
     * The field to search on.
     *
     * @var string
     */
    protected $field;

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
     * Sets the value to search with.
     *
     * @param mixed $value
     *
     * @return $this
     */
    public function value($value)
    {
        $this->body['value'] = $value;

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

    /**
     * Whether fuzzy transpositions (ab → ba) are supported.
     *
     * @param bool $status
     *
     * @return $this
     */
    public function transpositions(bool $status): self
    {
        $this->body['transpositions'] = $status;

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

        if (! isset($this->body['value'])) {
            throw new InvalidArgumentException('The "value" is required!');
        }

        $body = $this->body;

        if (count($body) === 1) {
            $body = $body['value'];
        }

        return [
            'fuzzy' => [
                $this->field => $body,
            ],
        ];
    }
}
