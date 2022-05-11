<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Core\ArrayableInterface;
use Hypefactors\ElasticBuilder\Query\QueryInterface;

interface PrefixQueryInterface extends ArrayableInterface, QueryInterface
{
    /**
     * Sets the field to search on.
     */
    public function field(string $field): PrefixQueryInterface;

    /**
     * Sets the value to search with.
     */
    public function value(mixed $value): PrefixQueryInterface;

    /**
     * Method used to rewrite the query.
     *
     * @param string $value
     *
     * @return $this
     */
    public function rewrite(string $value): PrefixQueryInterface;

    /**
     * Allows ASCII case insensitive matching of the value
     * with the indexed field values when set to true.
     */
    public function caseInsensitive(bool $status): PrefixQueryInterface;
}
