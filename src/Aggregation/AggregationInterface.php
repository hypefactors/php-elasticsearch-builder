<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Aggregation;

use Hypefactors\ElasticBuilder\Core\ArrayableInterface;
use Hypefactors\ElasticBuilder\Core\JsonableInterface;
use Hypefactors\ElasticBuilder\Core\ScriptInterface;

interface AggregationInterface extends ArrayableInterface, JsonableInterface
{
    /**
     * Sets the Aggregation name.
     */
    public function name(string $name): AggregationInterface;

    /**
     * Sets the Aggregation field name.
     */
    public function field(string $field): AggregationInterface;

    /**
     * Add a sub-aggregation to this aggregation.
     */
    public function aggregation(AggregationInterface $aggregation): AggregationInterface;

    /**
     * Sets the Aggregation Metadata.
     */
    public function meta(array $meta): AggregationInterface;

    /**
     * Sets the Script parameter for the Aggregation.
     */
    public function script(ScriptInterface $script): AggregationInterface;

    /**
     * Returns the Aggregation body.
     */
    public function getBody(): array;
}
