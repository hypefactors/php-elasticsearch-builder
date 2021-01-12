<?php

declare(strict_types=1);

namespace Hypefactors\ElasticBuilder\Aggregation\Metrics;

use InvalidArgumentException;
use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Aggregation\Aggregation;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-max-aggregation.html
 */
class MaxAggregation extends Aggregation
{
    public function getBody(): array
    {
        if (! isset($this->body['field'])) {
            throw new InvalidArgumentException('The "field" is required!');
        }

        return [
            'max' => Util::recursivetoArray($this->body),
        ];
    }
}
