<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Aggregation\Metrics;

use Hypefactors\ElasticBuilder\Aggregation\Aggregation;
use Hypefactors\ElasticBuilder\Aggregation\AggregationInterface;
use Hypefactors\ElasticBuilder\Core\Util;
use InvalidArgumentException;
use RuntimeException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/search-aggregations-metrics-cardinality-aggregation.html#search-aggregations-metrics-cardinality-aggregation.html
 */
class CardinalityAggregation extends Aggregation implements CardinalityAggregationInterface
{
    public function aggregation(AggregationInterface $aggregation): AggregationInterface
    {
        throw new RuntimeException('Cardinality Aggregations do not support sub-aggregations');
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function precision(int $precisionThreshold): AggregationInterface
    {
        if ($precisionThreshold > 40000) {
            throw new InvalidArgumentException('The maximum precision threslhold supported value is 40000!');
        }

        $this->body['precision_threshold'] = $precisionThreshold;

        return $this;
    }

    public function getBody(): array
    {
        return [
            'cardinality' => Util::recursivetoArray($this->body),
        ];
    }
}
