<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Aggregation\Bucket;

use Hypefactors\ElasticBuilder\Aggregation\Aggregation;
use Hypefactors\ElasticBuilder\Core\Util;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/search-aggregations-bucket-terms-aggregation.html
 */
class TermsAggregation extends Aggregation implements TermsAggregationInterface
{
    public function collectMode(string $mode): TermsAggregationInterface
    {
        $modeLower = strtolower($mode);

        $validModes = [
            'breadth_first',
            'depth_first',
        ];

        if (! in_array($modeLower, $validModes, true)) {
            throw new InvalidArgumentException("The [{$mode}] mode is not valid!");
        }

        $this->body['collect_mode'] = $modeLower;

        return $this;
    }

    public function order(string $key, string $direction): TermsAggregationInterface
    {
        $this->body['order'][] = [
            $key => $direction,
        ];

        return $this;
    }

    public function size(int $size): TermsAggregationInterface
    {
        $this->body['size'] = $size;

        return $this;
    }

    public function shardSize(int $size): TermsAggregationInterface
    {
        $this->body['shard_size'] = $size;

        return $this;
    }

    public function showTermDocCountError(bool $status): TermsAggregationInterface
    {
        $this->body['show_term_doc_count_error'] = $status;

        return $this;
    }

    public function minDocCount(int $minDocCount): TermsAggregationInterface
    {
        $this->body['min_doc_count'] = $minDocCount;

        return $this;
    }

    public function shardMinDocCount(int $minDocCount): TermsAggregationInterface
    {
        $this->body['shard_min_doc_count'] = $minDocCount;

        return $this;
    }

    public function include($clause): TermsAggregationInterface
    {
        $this->body['include'] = $clause;

        return $this;
    }

    public function exclude($clause): TermsAggregationInterface
    {
        $this->body['exclude'] = $clause;

        return $this;
    }

    public function missing(string $value): TermsAggregationInterface
    {
        $this->body['missing'] = $value;

        return $this;
    }

    public function executionHint(string $hint): TermsAggregationInterface
    {
        $hintLower = strtolower($hint);

        $validHints = [
            'map',
            'global_ordinals',
            'global_ordinals_hash',
            'global_ordinals_low_cardinality',
        ];

        if (! in_array($hintLower, $validHints, true)) {
            throw new InvalidArgumentException("The [{$hint}] hint is not valid!");
        }

        $this->body['execution_hint'] = $hintLower;

        return $this;
    }

    public function getBody(): array
    {
        return [
            'terms' => Util::recursivetoArray($this->body),
        ];
    }
}
