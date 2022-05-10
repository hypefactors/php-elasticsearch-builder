<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Core\ArrayableInterface;
use Hypefactors\ElasticBuilder\Query\QueryInterface;

interface RegexpQueryInterface extends ArrayableInterface, QueryInterface
{
    /**
     * Sets the field to search on.
     */
    public function field(string $field): RegexpQueryInterface;

    /**
     * Enables optional operators for the regular expression.
     *
     * @throws \InvalidArgumentException
     */
    public function flags(array | string $flags): RegexpQueryInterface;

    /**
     * Maximum number of automaton states required for the query.
     */
    public function maxDeterminizedStates(int $value): RegexpQueryInterface;

    /**
     * Method used to rewrite the query.
     */
    public function rewrite(string $value): RegexpQueryInterface;

    /**
     * Sets the value to search with.
     */
    public function value(mixed $value): RegexpQueryInterface;
}
