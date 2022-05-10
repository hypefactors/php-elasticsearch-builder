<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Aggregation\Metrics;

use Hypefactors\ElasticBuilder\Aggregation\Aggregation;
use Hypefactors\ElasticBuilder\Aggregation\AggregationInterface;
use Hypefactors\ElasticBuilder\Core\Util;
use RuntimeException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/search-aggregations-metrics-sum-aggregation.html
 */
class SumAggregation extends Aggregation implements SumAggregationInterface
{
    public function aggregation(AggregationInterface $aggregation): AggregationInterface
    {
        throw new RuntimeException('Sum Aggregations do not support sub-aggregations');
    }

    public function getBody(): array
    {
        return [
            'sum' => Util::recursivetoArray($this->body),
        ];
    }
}
