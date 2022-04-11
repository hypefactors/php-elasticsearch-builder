<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Query;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-regexp-query.html
 */
class RegexpQuery extends Query
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
     * Enables optional operators for the regular expression.
     *
     * @param array|string $flags
     *
     * @throws \InvalidArgumentException
     *
     * @return $this
     */
    public function flags($flags): self
    {
        if (is_string($flags)) {
            $flags = explode('|', $flags);
        }

        $flags = array_map('strtoupper', $flags);

        $validFlags = ['ANYSTRING', 'COMPLEMENT', 'EMPTY', 'INTERSECTION', 'INTERVAL', 'NONE'];

        $invalidFlags = array_diff($flags, $validFlags);

        if (count($invalidFlags) > 0) {
            throw new InvalidArgumentException('The given flags are invalid: '.implode(', ', $invalidFlags));
        }

        $this->body['flags'] = implode('|', $flags);

        return $this;
    }

    /**
     * Maximum number of automaton states required for the query.
     *
     * @param int $value
     *
     * @return $this
     */
    public function maxDeterminizedStates(int $value)
    {
        $this->body['max_determinized_states'] = $value;

        return $this;
    }

    /**
     * Method used to rewrite the query.
     *
     * @param string $value
     *
     * @return $this
     */
    public function rewrite($value)
    {
        $this->body['rewrite'] = $value;

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
            'regexp' => [
                $this->field => $body,
            ],
        ];
    }
}
