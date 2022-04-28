<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Aggregation\Metrics;

use Hypefactors\ElasticBuilder\Aggregation\Aggregation;
use Hypefactors\ElasticBuilder\Aggregation\AggregationInterface;
use Hypefactors\ElasticBuilder\Core\Util;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-cardinality-aggregation.html#search-aggregations-metrics-cardinality-aggregation.html
 */
final class CardinalityAggregation extends Aggregation
{
    /**
     * The precision_threshold options allows to trade memory for accuracy, and defines
     * a unique count below which counts are expected to be close to accurate.
     *
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

    /**
     * Returns the Aggregation body.
     *
     * @throws \InvalidArgumentException
     */
    public function getBody(): array
    {
        if (! isset($this->body['field'])) {
            throw new InvalidArgumentException('The "field" is required!');
        }

        return [
            'cardinality' => Util::recursivetoArray($this->body),
        ];
    }
}
