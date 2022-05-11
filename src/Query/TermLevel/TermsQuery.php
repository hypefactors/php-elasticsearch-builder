<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Query;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-terms-query.html
 */
class TermsQuery extends Query implements TermsQueryInterface
{
    /**
     * The field to be searched against.
     */
    private string | null $field = null;

    /**
     * The terms that needs to match exactly on the field value.
     */
    private array $values = [];

    /**
     * The terms lookup values.
     */
    private array $termsLookup = [];

    public function field(string $field): TermsQueryInterface
    {
        $this->field = $field;

        return $this;
    }

    public function value(bool | int | string $value): TermsQueryInterface
    {
        $this->values[] = $value;

        return $this;
    }

    public function values(array $values): TermsQueryInterface
    {
        foreach ($values as $value) {
            $this->value($value);
        }

        return $this;
    }

    public function termsLookup(array $termsLookup): TermsQueryInterface
    {
        $this->termsLookup = $termsLookup;

        return $this;
    }

    public function index(string $index): TermsQueryInterface
    {
        $this->termsLookup['index'] = $index;

        return $this;
    }

    public function id(string $id): TermsQueryInterface
    {
        $this->termsLookup['id'] = $id;

        return $this;
    }

    public function path(string $path): TermsQueryInterface
    {
        $this->termsLookup['path'] = $path;

        return $this;
    }

    public function routing(string $routing): TermsQueryInterface
    {
        $this->termsLookup['routing'] = $routing;

        return $this;
    }

    public function build(): array
    {
        if (! $this->field) {
            throw new InvalidArgumentException('The "field" is required!');
        }

        if (empty($this->values) && empty($this->termsLookup)) {
            throw new InvalidArgumentException('The "values" are required!');
        }

        if (count($this->termsLookup) > 0) {
            $values = array_unique($this->termsLookup);
        } else {
            $values = array_values(array_unique($this->values));
        }

        return [
            'terms' => array_merge([
                $this->field => $values,
            ], $this->body),
        ];
    }
}
