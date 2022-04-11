<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Aggregation;

use Hypefactors\ElasticBuilder\Script\ScriptInterface;

interface AggregationInterface
{
    /**
     * Sets the Aggregation name.
     *
     * @param string $name
     *
     * @return \Hypefactors\ElasticBuilder\Aggregation\AggregationInterface
     */
    public function name(string $name): AggregationInterface;

    /**
     * Sets the Aggregation field name.
     *
     * @param string $name
     *
     * @return \Hypefactors\ElasticBuilder\Aggregation\AggregationInterface
     */
    public function field(string $field): AggregationInterface;

    public function aggregation(AggregationInterface $aggregation): AggregationInterface;

    public function aggregations(array $aggregations): AggregationInterface;

    /**
     * Sets the Aggregation Metadata.
     *
     * @param array $meta
     *
     * @return \Hypefactors\ElasticBuilder\Aggregation\AggregationInterface
     */
    public function meta(array $meta): AggregationInterface;

    /**
     * Sets the Script parameter for the Aggregation.
     *
     * @param \Hypefactors\ElasticBuilder\Script\ScriptInterface $script
     *
     * @return \Hypefactors\ElasticBuilder\Aggregation\AggregationInterface
     */
    public function script(ScriptInterface $script): AggregationInterface;

    /**
     * Returns the Aggregation body.
     *
     * @return array
     */
    public function getBody(): array;

    /**
     * Returns the DSL Query as an array.
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Returns the query in JSON format.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson(int $options = 0): string;
}
