<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query;

use Hypefactors\ElasticBuilder\Core\Util;
use stdClass;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-match-all-query.html
 */
class MatchAllQuery extends Query implements MatchAllQueryInterface
{
    public function build(): array
    {
        return [
            'match_all' => Util::recursivetoArray($this->body) ?? new stdClass(),
        ];
    }
}
