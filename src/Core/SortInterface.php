<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Core;

interface SortInterface extends ArrayableInterface, JsonableInterface
{
    /**
     * The field to be sorted.
     */
    public function field(string $field): SortInterface;

    /**
     * Allow to sort based on custom scripts.
     */
    public function script(ScriptInterface $script): SortInterface;

    /**
     * The missing parameter specifies how docs which are missing the sort field should be treated.
     *
     * @param mixed $value
     */
    public function missing($value): SortInterface;

    /**
     * Sets the mode option that controls what array value
     * is picked for sorting the document it belongs to.
     *
     * @throws \InvalidArgumentException
     */
    public function mode(string $mode): SortInterface;

    /**
     * For numeric fields it is also possible to cast the values
     * from one type to another using the numeric_type option.
     *
     * @throws \InvalidArgumentException
     */
    public function numericType(string $numericType): SortInterface;

    /**
     * Sets the order for sorting.
     *
     * @throws \InvalidArgumentException
     */
    public function order(string $order): SortInterface;

    /**
     * The `unmapped_type` option allows to ignore fields that have no mapping
     * and not sort by them.
     */
    public function unmappedType(string $type): SortInterface;
}
