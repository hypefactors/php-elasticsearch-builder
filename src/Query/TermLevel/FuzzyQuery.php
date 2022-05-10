<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Query;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-fuzzy-query.html
 */
class FuzzyQuery extends Query implements FuzzyQueryInterface
{
    /**
     * The field to search on.
     */
    private string | null $field = null;

    public function field(string $field): FuzzyQueryInterface
    {
        $this->field = $field;

        return $this;
    }

    public function value(mixed $value): FuzzyQueryInterface
    {
        $this->body['value'] = $value;

        return $this;
    }

    public function fuzziness(int | string $factor): FuzzyQueryInterface
    {
        $this->body['fuzziness'] = $factor;

        return $this;
    }

    public function maxExpansions(int $limit): FuzzyQueryInterface
    {
        $this->body['max_expansions'] = $limit;

        return $this;
    }

    public function prefixLength(int $length): FuzzyQueryInterface
    {
        $this->body['prefix_length'] = $length;

        return $this;
    }

    public function transpositions(bool $status): FuzzyQueryInterface
    {
        $this->body['transpositions'] = $status;

        return $this;
    }

    public function rewrite(string $value): FuzzyQueryInterface
    {
        $this->body['rewrite'] = $value;

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
            'fuzzy' => [
                $this->field => $body,
            ],
        ];
    }
}
