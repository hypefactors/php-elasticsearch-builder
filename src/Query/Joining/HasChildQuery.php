<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Joining;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-exists-query.html
 */
class HasChildQuery extends Query
{
    /**
     * Sets the field to search on.
     *
     * @param string $field
     *
     * @return $this
     */
    public function field(string $field): self
    {
        $this->body['field'] = $field;

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
        if (! isset($this->body['field'])) {
            throw new InvalidArgumentException('The "field" is required!');
        }

        return [
            'exists' => Util::recursivetoArray($this->body),
        ];
    }
}
