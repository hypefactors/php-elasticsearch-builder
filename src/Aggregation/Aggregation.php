<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Aggregation;

use Hypefactors\ElasticBuilder\Core\ScriptInterface;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations.html
 */
abstract class Aggregation implements AggregationInterface
{
    /**
     * The Aggregation name.
     */
    protected string | null $name = null;

    /**
     * The Aggregation body.
     */
    protected array $body = [];

    /**
     * The Aggregation Metadata.
     */
    protected array $meta = [];

    /**
     * The Nested Aggregations of this Aggregation.
     */
    protected array $nestedAggregations = [];

    public function name(string $name): AggregationInterface
    {
        $this->name = $name;

        return $this;
    }

    public function field(string $field): AggregationInterface
    {
        $this->body['field'] = $field;

        return $this;
    }

    public function aggregation(AggregationInterface $aggregation): AggregationInterface
    {
        $this->nestedAggregations[] = $aggregation;

        return $this;
    }

    public function meta(array $meta): AggregationInterface
    {
        $this->meta = $meta;

        return $this;
    }

    public function script(ScriptInterface $script): AggregationInterface
    {
        $this->body['script'] = $script;

        return $this;
    }

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

    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
