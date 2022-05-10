<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Aggregation\Bucket;

interface TermsAggregationInterface
{
    public function collectMode(string $mode): TermsAggregationInterface;

    public function order(string $key, string $direction): TermsAggregationInterface;

    public function size(int $size): TermsAggregationInterface;

    public function shardSize(int $size): TermsAggregationInterface;

    public function showTermDocCountError(bool $status): TermsAggregationInterface;

    public function minDocCount(int $minDocCount): TermsAggregationInterface;

    public function shardMinDocCount(int $minDocCount): TermsAggregationInterface;

    public function include($clause): TermsAggregationInterface;

    public function exclude($clause): TermsAggregationInterface;

    public function missing(string $value): TermsAggregationInterface;

    public function executionHint(string $hint): TermsAggregationInterface;
}
