<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query;

use Hypefactors\ElasticBuilder\Core\Util;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-all-query.html#query-dsl-match-none-query
 */
class MatchNoneQuery extends Query
{
    /**
     * Returns the DSL Query as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'match_none' => Util::recursivetoArray($this->body),
        ];
    }
}
