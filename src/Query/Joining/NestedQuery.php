<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Joining;

use Hypefactors\ElasticBuilder\Core\InnerHits;
use Hypefactors\ElasticBuilder\Core\InnerHitsInterface;
use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;
use Hypefactors\ElasticBuilder\Query\QueryInterface;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-nested-query.html
 */
class NestedQuery extends Query implements NestedQueryInterface
{
    public function path(string $path): NestedQueryInterface
    {
        $this->body['path'] = $path;

        return $this;
    }

    public function query(QueryInterface $query): NestedQueryInterface
    {
        $this->body['query'] = $query;

        return $this;
    }

    public function scoreMode(string $scoreMode): NestedQueryInterface
    {
        $scoreModeLower = strtolower($scoreMode);

        $validscoreModes = ['avg', 'max', 'min', 'none', 'sum'];

        if (! in_array($scoreModeLower, $validscoreModes, true)) {
            throw new InvalidArgumentException("The [{$scoreMode}] score mode is invalid.");
        }

        $this->body['score_mode'] = $scoreModeLower;

        return $this;
    }

    public function ignoreUnmapped(bool $status): NestedQueryInterface
    {
        $this->body['ignore_unmapped'] = $status;

        return $this;
    }

    public function innerHits(callable | InnerHitsInterface $value): NestedQueryInterface
    {
        if (is_callable($value)) {
            $innerHits = new InnerHits();

            $value($innerHits);

            return $this->innerHits($innerHits);
        }

        if (! $value->isEmpty()) {
            $this->body['inner_hits'] = $value->build();
        }

        return $this;
    }

    public function build(): array
    {
        if (! isset($this->body['path'])) {
            throw new InvalidArgumentException('The "path" is required!');
        }

        if (! isset($this->body['query'])) {
            throw new InvalidArgumentException('The "query" is required!');
        }

        return [
            'nested' => Util::recursivetoArray($this->body),
        ];
    }
}
