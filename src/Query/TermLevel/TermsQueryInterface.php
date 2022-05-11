<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Core\ArrayableInterface;
use Hypefactors\ElasticBuilder\Query\QueryInterface;

interface TermsQueryInterface extends ArrayableInterface, QueryInterface
{
    /**
     * Sets the field to search on.
     */
    public function field(string $field): TermsQueryInterface;

    /**
     * Sets a term that needs to match on the field value.
     */
    public function value(bool | int | string $value): TermsQueryInterface;

    /**
     * Sets multiple terms that needs to match on the field value.
     */
    public function values(array $values): TermsQueryInterface;

    /**
     * Terms lookup fetches the field values of an existing document.
     */
    public function termsLookup(array $termsLookup): TermsQueryInterface;

    /**
     * Sets the "name" of the index from which to fetch field values.
     */
    public function index(string $index): TermsQueryInterface;

    /**
     * Sets the "id" of the document from which to fetch field values.
     */
    public function id(string $id): TermsQueryInterface;

    /**
     * Sets the name of the field from which to fetch field values.
     */
    public function path(string $path): TermsQueryInterface;

    /**
     * Sets the custom routing value of the document
     * from which to fetch term values.
     */
    public function routing(string $routing): TermsQueryInterface;
}
