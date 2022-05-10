<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText;

use Hypefactors\ElasticBuilder\Core\ArrayableInterface;
use Hypefactors\ElasticBuilder\Query\QueryInterface;

interface MatchPhrasePrefixQueryInterface extends ArrayableInterface, QueryInterface
{
    /**
     * Sets the field to search on.
     */
    public function field(string $field): MatchPhrasePrefixQueryInterface;

    public function query($query): MatchPhrasePrefixQueryInterface;

    /**
     * Analyzer used to convert text in the query value into tokens.
     */
    public function analyzer(string $analyzer): MatchPhrasePrefixQueryInterface;

    /**
     * Maximum number of terms to which the last provided term of the query value will expand.
     */
    public function maxExpansions(int $maxExpansions): MatchPhrasePrefixQueryInterface;

    /**
     * Maximum number of positions allowed between matching tokens.
     */
    public function slop(int $slop): MatchPhrasePrefixQueryInterface;

    /**
     * Indicates whether no documents are returned if the analyzer
     * removes all tokens, such as when using a stop filter.
     */
    public function zeroTermsQuery(string $status): MatchPhrasePrefixQueryInterface;
}
