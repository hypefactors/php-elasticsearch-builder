<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Aggregation\Metrics;

use Hypefactors\ElasticBuilder\Aggregation\AggregationInterface;

interface CardinalityAggregationInterface
{
    /**
     * The precision_threshold options allows to trade memory for accuracy, and defines
     * a unique count below which counts are expected to be close to accurate.
     *
     * @throws \InvalidArgumentException
     */
    public function precision(int $precisionThreshold): AggregationInterface;
}
