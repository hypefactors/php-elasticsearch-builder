<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Span;

use Hypefactors\ElasticBuilder\Core\ArrayableInterface;

interface SpanTermQueryInterface extends ArrayableInterface, SpanQueryInterface
{
    /**
     * Sets the field to search on.
     */
    public function field(string $field): SpanTermQueryInterface;

    /**
     * Sets the value to search with.
     */
    public function value(mixed $value): SpanTermQueryInterface;
}
