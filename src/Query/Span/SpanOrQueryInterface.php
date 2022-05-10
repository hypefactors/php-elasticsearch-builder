<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Span;

use Hypefactors\ElasticBuilder\Core\ArrayableInterface;

interface SpanOrQueryInterface extends ArrayableInterface, SpanQueryInterface
{
    /**
     * Adds a Span Term query.
     */
    public function spanTerm(callable | SpanTermQueryInterface $value): SpanOrQueryInterface;

    /**
     * Adds a Span Near query.
     */
    public function spanNear(callable | SpanNearQueryInterface $value): SpanOrQueryInterface;
}
