<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Span;

use Hypefactors\ElasticBuilder\Core\ArrayableInterface;

interface SpanNearQueryInterface extends ArrayableInterface, SpanQueryInterface
{
    /**
     * Adds a Span Term query.
     */
    public function spanTerm(callable | SpanTermQueryInterface $value): SpanNearQueryInterface;

    /**
     * Adds a Span Or query.
     */
    public function spanOrQuery(callable | SpanOrQueryInterface $value): SpanNearQueryInterface;

    /**
     * Determines wether matches are required to be in-order.
     */
    public function inOrder(bool $status): SpanNearQueryInterface;

    /**
     * Controls the maximum number of intervening unmatched positions permitted.
     */
    public function slop(int $slop): SpanNearQueryInterface;
}
