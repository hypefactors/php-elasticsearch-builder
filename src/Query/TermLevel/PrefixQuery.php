<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Query;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-prefix-query.html
 */
class PrefixQuery extends Query implements PrefixQueryInterface
{
    /**
     * The field to search on.
     */
    private string | null $field = null;

    public function field(string $field): PrefixQueryInterface
    {
        $this->field = $field;

        return $this;
    }

    public function value($value): PrefixQueryInterface
    {
        $this->body['value'] = $value;

        return $this;
    }

    public function rewrite(string $value): PrefixQueryInterface
    {
        $this->body['rewrite'] = $value;

        return $this;
    }

    public function caseInsensitive(bool $status): PrefixQueryInterface
    {
        $this->body['case_insensitive'] = $status;

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
            'prefix' => [
                $this->field => $body,
            ],
        ];
    }
}
