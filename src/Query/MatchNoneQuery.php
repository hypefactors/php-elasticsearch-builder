<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query;

use Hypefactors\ElasticBuilder\Core\Util;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-match-all-query.html#query-dsl-match-none-query
 */
class MatchNoneQuery extends Query implements MatchNoneQueryInterface
{
    public function build(): array
    {
        return [
            'match_none' => Util::recursivetoArray($this->body),
        ];
    }
}
