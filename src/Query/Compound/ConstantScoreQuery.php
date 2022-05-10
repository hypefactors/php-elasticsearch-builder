<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Compound;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;
use Hypefactors\ElasticBuilder\Query\QueryInterface;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-constant-score-query.html
 */
class ConstantScoreQuery extends Query implements ConstantScoreQueryInterface
{
    public function filter(QueryInterface $query): ConstantScoreQueryInterface
    {
        $this->body['filter'] = $query;

        return $this;
    }

    public function build(): array
    {
        if (empty($this->body)) {
            return [];
        }

        if (! isset($this->body['filter'])) {
            throw new InvalidArgumentException('The "filter" query is required!');
        }

        return [
            'constant_score' => Util::recursivetoArray($this->body),
        ];
    }
}
