<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Core\ArrayableInterface;
use Hypefactors\ElasticBuilder\Query\QueryInterface;

interface FuzzyQueryInterface extends ArrayableInterface, QueryInterface
{
    /**
     * Sets the field to search on.
     */
    public function field(string $field): FuzzyQueryInterface;

    /**
     * Sets the value to search with.
     */
    public function value(mixed $value): FuzzyQueryInterface;

    /**
     * The maximum edit distance.
     */
    public function fuzziness(int | string $factor): FuzzyQueryInterface;

    /**
     * The maximum number of terms that the fuzzy query will expand to.
     */
    public function maxExpansions(int $limit): FuzzyQueryInterface;

    /**
     * The number of initial characters which will not be "fuzzified".
     */
    public function prefixLength(int $length): FuzzyQueryInterface;

    /**
     * Whether fuzzy transpositions (ab → ba) are supported.
     */
    public function transpositions(bool $status): FuzzyQueryInterface;

    /**
     * Method used to rewrite the query.
     */
    public function rewrite(string $value): FuzzyQueryInterface;
}
