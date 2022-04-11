<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Query;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-terms-query.html
 */
class TermsQuery extends Query
{
    /**
     * The field to be searched against.
     *
     * @var string
     */
    protected $field;

    /**
     * The terms that needs to match exactly on the field value.
     *
     * @var array
     */
    protected $values = [];

    /**
     * The terms lookup values.
     *
     * @var array
     */
    protected $termsLookup = [];

    /**
     * Sets the field to be searched against.
     *
     * @param string $field
     *
     * @return $this
     */
    public function field(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Sets a term that needs to match on the field value.
     *
     * @param bool|int|string $value
     *
     * @return $this
     */
    public function value($value): self
    {
        $this->values[] = $value;

        return $this;
    }

    /**
     * Sets multiple terms that needs to match on the field value.
     *
     * @param array $values
     *
     * @return $this
     */
    public function values(array $values): self
    {
        foreach ($values as $value) {
            $this->value($value);
        }

        return $this;
    }

    /**
     * Terms lookup fetches the field values of an existing document.
     *
     * @param array $termsLookup
     *
     * @return $this
     */
    public function termsLookup(array $termsLookup): self
    {
        $this->termsLookup = $termsLookup;

        return $this;
    }

    /**
     * Sets the "name" of the index from which to fetch field values.
     *
     * @param string $index
     *
     * @return $this
     */
    public function index(string $index): self
    {
        $this->termsLookup['index'] = $index;

        return $this;
    }

    /**
     * Sets the "id" of the document from which to fetch field values.
     *
     * @param string $id
     *
     * @return $this
     */
    public function id(string $id): self
    {
        $this->termsLookup['id'] = $id;

        return $this;
    }

    /**
     * Sets the name of the field from which to fetch field values.
     *
     * @param string $path
     *
     * @return $this
     */
    public function path(string $path): self
    {
        $this->termsLookup['path'] = $path;

        return $this;
    }

    /**
     * Sets the custom routing value of the document
     * from which to fetch term values.
     *
     * @param string $routing
     *
     * @return $this
     */
    public function routing(string $routing): self
    {
        $this->termsLookup['routing'] = $routing;

        return $this;
    }

    /**
     * Returns the DSL Query as an array.
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function toArray(): array
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
