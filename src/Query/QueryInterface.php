<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query;

use Hypefactors\ElasticBuilder\Core\ArrayableInterface;

interface QueryInterface extends ArrayableInterface
{
    /**
     * Sets the boost value to increase or decrease the relevance scores of this query.
     */
    public function boost(float $factor): QueryInterface;

    /**
     * Sets the query name.
     */
    public function name(string $name): QueryInterface;
}
