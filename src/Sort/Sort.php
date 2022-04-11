<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Sort;

use Hypefactors\ElasticBuilder\Core\GeoPoint;
use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Script\ScriptInterface;
use InvalidArgumentException;
use stdClass;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-request-body.html#request-body-search-sort
 */
final class Sort implements SortInterface
{
    /**
     * The field to be sorted.
     *
     * @var string
     */
    protected $field;

    /**
     * The sorting options to be applied.
     *
     * @var array
     */
    protected $options = [];

    // protected $geoPoint;

    /**
     * The Script instance to be used for a Script Based Sorting.
     *
     * @var \Hypefactors\ElasticBuilder\Script\ScriptInterface
     */
    protected $script;

    /**
     * The list of valid orders.
     *
     * @var array
     */
    public const VALID_ORDERS = ['asc', 'desc'];

    /**
     * The list of valid modes.
     *
     * @var array
     */
    public const VALID_MODES = ['min', 'max', 'sum', 'avg', 'median'];

    /**
     * The list of valid numeric types.
     *
     * @var array
     */
    public const VALID_NUMERIC_TYPES = ['double', 'long', 'date', 'date_nanos'];

    /**
     * Constructor.
     *
     * @param string|null $field
     * @param string|null $order
     *
     * @return void
     */
    public function __construct(?string $field = null, ?string $order = null)
    {
        $field && $this->field($field);

        $order && $this->order($order);
    }

    /**
     * {@inheritdoc}
     */
    public function field(string $field): SortInterface
    {
        $this->field = $field;

        return $this;
    }

    // /**
    //  * {@inheritdoc}
    //  */
    // public function geoDistance(GeoPoint $geoPoint): SortInterface
    // {
    //     $this->geoPoint = $geoPoint;

    //     return $this;
    // }

    /**
     * {@inheritdoc}
     */
    public function script(ScriptInterface $script): SortInterface
    {
        $this->script = $script;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function missing($value): SortInterface
    {
        $this->options['missing'] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function mode(string $mode): SortInterface
    {
        $modeLower = strtolower($mode);

        if (! in_array($modeLower, self::VALID_MODES, true)) {
            throw new InvalidArgumentException("The [{$mode}] mode is invalid!");
        }

        $this->options['mode'] = $modeLower;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function numericType(string $numericType): SortInterface
    {
        $numericTypeLower = strtolower($numericType);

        if (! in_array($numericTypeLower, self::VALID_NUMERIC_TYPES, true)) {
            throw new InvalidArgumentException("The [{$numericType}] numeric type is invalid!");
        }

        $this->options['numeric_type'] = $numericTypeLower;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function order(string $order): SortInterface
    {
        $orderLower = strtolower($order);

        if (! in_array($orderLower, self::VALID_ORDERS, true)) {
            throw new InvalidArgumentException("The [{$order}] order is invalid!");
        }

        $this->options['order'] = $orderLower;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function unmappedType(string $type): SortInterface
    {
        $this->options['unmapped_type'] = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        // if ($this->geoPoint) {
        //     return [
        //         '_geo_distance' => [
        //             $this->field => array_merge($this->geoPoint->toArray(), $this->options),
        //         ],
        //     ];
        // }

        if ($this->script) {
            return [
                '_script' => array_merge($this->options, [
                    'script' => $this->script->toArray(),
                ]),
            ];
        }

        if (empty($this->options)) {
            return [
                $this->field => new stdClass(),
            ];
        }

        if (count($this->options) === 1 && isset($this->options['order'])) {
            return [
                $this->field => $this->options['order'],
            ];
        }

        return [
            $this->field => Util::recursivetoArray($this->options),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
