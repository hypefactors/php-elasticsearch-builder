<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-type-query.html
 */
class TypeQuery extends Query
{
    /**
     * Sets the type to search on.
     *
     * @param string $type
     *
     * @return $this
     */
    public function type($type): self
    {
        $this->body['value'] = $type;

        return $this;
    }

    /**
     * Returns the DSL Query as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => Util::recursivetoArray($this->body),
        ];
    }
}
