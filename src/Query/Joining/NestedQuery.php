<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Joining;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;
use Hypefactors\ElasticBuilder\Query\QueryInterface;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-nested-query.html
 */
class NestedQuery extends Query
{
    /**
     * Sets the path to search on.
     *
     * @param string $path
     *
     * @return $this
     */
    public function path(string $path): self
    {
        $this->body['path'] = $path;

        return $this;
    }

    /**
     * Sets the Query to be ran on the nested objects in the path.
     *
     * @param \Hypefactors\ElasticBuilder\Query\QueryInterface $query
     *
     * @return $this
     */
    public function query(QueryInterface $query): self
    {
        $this->body['query'] = $query;

        return $this;
    }

    /**
     * Indicates how scores for matching child objects affect the root parent document’s relevance score.
     *
     * @param string $scoreMode
     *
     * @return $this
     */
    public function scoreMode(string $scoreMode): self
    {
        $scoreModeLower = strtolower($scoreMode);

        $validscoreModes = ['avg', 'max', 'min', 'none', 'sum'];

        if (! in_array($scoreModeLower, $validscoreModes, true)) {
            throw new InvalidArgumentException("The [{$scoreMode}] score mode is invalid.");
        }

        $this->body['score_mode'] = $scoreModeLower;

        return $this;
    }

    /**
     * Indicates whether to ignore an unmapped path and not return any documents instead of an error.
     *
     * @param bool $status
     *
     * @return $this
     */
    public function ignoreUnmapped(bool $status): self
    {
        $this->body['ignore_unmapped'] = $status;

        return $this;
    }

    /**
     * Returns the DSL Query as an array.
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function toArray(): array
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
