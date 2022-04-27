<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Aggregation;

use Hypefactors\ElasticBuilder\Core\ScriptInterface;
use InvalidArgumentException;

abstract class Aggregation implements AggregationInterface
{
    /**
     * The Aggregation name.
     *
     * @var string
     */
    protected $name;

    /**
     * The Aggregation body.
     *
     * @var array
     */
    protected $body = [];

    /**
     * The Aggregation Metadata.
     *
     * @var array
     */
    protected $meta = [];

    /**
     * The Nested Aggregations of this Aggregation.
     *
     * @var array
     */
    protected $nestedAggregations = [];

    /**
     * {@inheritdoc}
     */
    public function name(string $name): AggregationInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function field(string $field): AggregationInterface
    {
        $this->body['field'] = $field;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function aggregation(AggregationInterface $aggregation): AggregationInterface
    {
        $this->nestedAggregations[] = $aggregation;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function aggregations(array $aggregations): AggregationInterface
    {
        foreach ($aggregations as $aggregation) {
            $this->aggregation($aggregation);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function meta(array $meta): AggregationInterface
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function script(ScriptInterface $script): AggregationInterface
    {
        $this->body['script'] = $script;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        if (! $this->name) {
            throw new InvalidArgumentException('The Aggregation "name" is required!');
        }

        $body = $this->getBody();

        if (! empty($this->nestedAggregations)) {
            $nestedAggregations = [];

            foreach ($this->nestedAggregations as $nestedAggregation) {
                $nestedAggregations += $nestedAggregation->toArray();
            }

            $body['aggs'] = $nestedAggregations;
        }

        if (! empty($this->meta)) {
            $body['meta'] = $this->meta;
        }

        return [
            $this->name => $body,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
