<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Joining;

use Hypefactors\ElasticBuilder\Core\ArrayableInterface;
use Hypefactors\ElasticBuilder\Core\InnerHitsInterface;
use Hypefactors\ElasticBuilder\Query\QueryInterface;

interface NestedQueryInterface extends ArrayableInterface, QueryInterface
{
    /**
     * Sets the path to search on.
     */
    public function path(string $path): NestedQueryInterface;

    /**
     * Sets the Query to be ran on the nested objects in the path.
     */
    public function query(QueryInterface $query): NestedQueryInterface;

    /**
     * Indicates how scores for matching child objects affect the root parent document’s relevance score.
     *
     * @throws \InvalidArgumentException
     */
    public function scoreMode(string $scoreMode): NestedQueryInterface;

    /**
     * Indicates whether to ignore an unmapped path and not return any documents instead of an error.
     */
    public function ignoreUnmapped(bool $status): NestedQueryInterface;

    public function innerHits(callable | InnerHitsInterface $value): NestedQueryInterface;
}
