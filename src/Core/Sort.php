<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Core;

use InvalidArgumentException;
use stdClass;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/sort-search-results.html
 */
final class Sort implements SortInterface
{
    /**
     * The field to be sorted.
     */
    private string | null $field = null;

    /**
     * The sorting options to be applied.
     */
    private array $options = [];

    /**
     * The Script instance to be used for a Script Based Sorting.
     */
    private ScriptInterface | null $script = null;

    /**
     * The list of valid sort orders.
     */
    public const VALID_ORDERS = [
        'asc',
        'desc',
    ];

    /**
     * The list of valid modes.
     */
    public const VALID_MODES = [
        'min',
        'max',
        'sum',
        'avg',
        'median',
    ];

    /**
     * The list of valid numeric types.
     */
    public const VALID_NUMERIC_TYPES = [
        'double',
        'long',
        'date',
        'date_nanos',
    ];

    public function __construct(
        string | null $field = null,
        string | null $order = null,
    ) {
        $field && $this->field($field);

        $order && $this->order($order);
    }

    public function field(string $field): SortInterface
    {
        $this->field = $field;

        return $this;
    }

    public function script(ScriptInterface $script): SortInterface
    {
        $this->script = $script;

        return $this;
    }

    public function missing($value): SortInterface
    {
        $this->options['missing'] = $value;

        return $this;
    }

    public function mode(string $mode): SortInterface
    {
        $modeLower = strtolower($mode);

        if (! in_array($modeLower, self::VALID_MODES, true)) {
            throw new InvalidArgumentException("The [{$mode}] mode is invalid!");
        }

        $this->options['mode'] = $modeLower;

        return $this;
    }

    public function numericType(string $numericType): SortInterface
    {
        $numericTypeLower = strtolower($numericType);

        if (! in_array($numericTypeLower, self::VALID_NUMERIC_TYPES, true)) {
            throw new InvalidArgumentException("The [{$numericType}] numeric type is invalid!");
        }

        $this->options['numeric_type'] = $numericTypeLower;

        return $this;
    }

    public function order(string $order): SortInterface
    {
        $orderLower = strtolower($order);

        if (! in_array($orderLower, self::VALID_ORDERS, true)) {
            throw new InvalidArgumentException("The [{$order}] order is invalid!");
        }

        $this->options['order'] = $orderLower;

        return $this;
    }

    public function unmappedType(string $type): SortInterface
    {
        $this->options['unmapped_type'] = $type;

        return $this;
    }

    public function toArray(): array
    {
        if ($this->script) {
            return [
                '_script' => array_merge($this->options, [
                    'script' => $this->script->toArray(),
                ]),
            ];
        }

        if ($this->field === null) {
            throw new InvalidArgumentException('The "field" is required!');
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

    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
