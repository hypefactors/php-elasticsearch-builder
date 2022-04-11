<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Sort;

use Hypefactors\ElasticBuilder\Core\GeoPoint;
use Hypefactors\ElasticBuilder\Script\ScriptInterface;

interface SortInterface
{
    /**
     * The field to be sorted.
     *
     * @param string $field
     *
     * @return \Hypefactors\ElasticBuilder\Sort\SortInterface
     */
    public function field(string $field): SortInterface;

    // /**
    //  * Allow to sort by _geo_distance.
    //  *
    //  * @param \Hypefactors\ElasticBuilder\Core\GeoPoint $geoPoint
    //  *
    //  * @return \Hypefactors\ElasticBuilder\Sort\SortInterface
    //  */
    // public function geoDistance(GeoPoint $geoPoint): SortInterface;

    /**
     * Allow to sort based on custom scripts.
     *
     * @param \Hypefactors\ElasticBuilder\Script\ScriptInterface $script
     *
     * @return \Hypefactors\ElasticBuilder\Sort\SortInterface
     */
    public function script(ScriptInterface $script): SortInterface;

    /**
     * The missing parameter specifies how docs which are missing the sort field should be treated.
     *
     * @param int|string $value
     *
     * @return \Hypefactors\ElasticBuilder\Sort\SortInterface
     */
    public function missing($value): SortInterface;

    /**
     * Sets the mode option that controls what array value
     * is picked for sorting the document it belongs to.
     *
     * @param string $mode
     *
     * @throws \InvalidArgumentException
     *
     * @return \Hypefactors\ElasticBuilder\Sort\SortInterface
     */
    public function mode(string $mode): SortInterface;

    /**
     * For numeric fields it is also possible to cast the values
     * from one type to another using the numeric_type option.
     *
     * @param string $numericType
     *
     * @throws \InvalidArgumentException
     *
     * @return \Hypefactors\ElasticBuilder\Sort\SortInterface
     */
    public function numericType(string $numericType): SortInterface;

    /**
     * Sets the order for sorting.
     *
     * @param string $order
     *
     * @throws \InvalidArgumentException
     *
     * @return \Hypefactors\ElasticBuilder\Sort\SortInterface
     */
    public function order(string $order): SortInterface;

    /**
     * The `unmapped_type` option allows to ignore fields that have no mapping
     * and not sort by them.
     *
     * @param string $type
     *
     * @return \Hypefactors\ElasticBuilder\Sort\SortInterface
     */
    public function unmappedType(string $type): SortInterface;

    /**
     * Returns the DSL Sort as an array.
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Returns the query in JSON format.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson(int $options = 0): string;
}
