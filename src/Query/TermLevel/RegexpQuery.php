<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Query;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-regexp-query.html
 */
class RegexpQuery extends Query implements RegexpQueryInterface
{
    /**
     * The field to search on.
     */
    private string | null $field = null;

    public function field(string $field): RegexpQueryInterface
    {
        $this->field = $field;

        return $this;
    }

    public function flags(array | string $flags): RegexpQueryInterface
    {
        if (is_string($flags)) {
            $flags = explode('|', $flags);
        }

        $flags = array_map('strtoupper', $flags);

        $validFlags = [
            'ANYSTRING',
            'COMPLEMENT',
            'EMPTY',
            'INTERSECTION',
            'INTERVAL',
            'NONE',
        ];

        $invalidFlags = array_diff($flags, $validFlags);

        if (count($invalidFlags) > 0) {
            throw new InvalidArgumentException('The given flags are invalid: '.implode(', ', $invalidFlags));
        }

        $this->body['flags'] = implode('|', $flags);

        return $this;
    }

    public function maxDeterminizedStates(int $value): RegexpQueryInterface
    {
        $this->body['max_determinized_states'] = $value;

        return $this;
    }

    public function rewrite(string $value): RegexpQueryInterface
    {
        $this->body['rewrite'] = $value;

        return $this;
    }

    public function value(mixed $value): RegexpQueryInterface
    {
        $this->body['value'] = $value;

        return $this;
    }

    public function build(): array
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
