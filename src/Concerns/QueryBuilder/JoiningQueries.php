<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Concerns\QueryBuilder;

use Hypefactors\ElasticBuilder\Query\Joining\NestedQuery;
use Hypefactors\ElasticBuilder\Query\Joining\NestedQueryInterface;
use Hypefactors\ElasticBuilder\QueryBuilderInterface;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/joining-queries.html
 */
trait JoiningQueries
{
    public function nested(callable | NestedQueryInterface $value): QueryBuilderInterface
    {
        if (is_callable($value)) {
            $nestedQuery = new NestedQuery();

            $value($nestedQuery);

            return $this->nested($nestedQuery);
        }

        $this->body[] = $value;

        return $this;
    }
}
