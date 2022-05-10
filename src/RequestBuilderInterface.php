<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder;

use Hypefactors\ElasticBuilder\Aggregation\AggregationInterface;
use Hypefactors\ElasticBuilder\Core\CollapseInterface;
use Hypefactors\ElasticBuilder\Core\HighlightInterface;
use Hypefactors\ElasticBuilder\Core\ScriptInterface;
use Hypefactors\ElasticBuilder\Core\SortInterface;

interface RequestBuilderInterface
{
    public function option(string $option, int | string | bool $value): RequestBuilderInterface;

    public function options(array $options): RequestBuilderInterface;

    public function index(string $indexes): RequestBuilderInterface;

    /**
     * Allows to return the doc value representation of a field for each hit.
     */
    public function docValueField(string $field, string | null $format = null): RequestBuilderInterface;

    /**
     * Enables or disables the explanation status for
     * each hit on how its score was computed.
     */
    public function explain(bool $status): RequestBuilderInterface;

    /**
     * Allows to collapse search results based on field values. The collapsing
     * is done by selecting only the top sorted document per collapse key.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/collapse-search-results.html
     */
    public function collapse(callable | CollapseInterface $value): RequestBuilderInterface;

    /**
     * To retrieve hits from a certain offset.
     */
    public function from(int | string $from): RequestBuilderInterface;

    /**
     * The number of hits to return.
     */
    public function size(int | string $size): RequestBuilderInterface;

    /**
     * Allows to highlight search results on one or more fields.
     */
    public function highlight(callable | HighlightInterface $value): RequestBuilderInterface;

    /**
     * Exclude documents which have a "_score" less than the given minimum score.
     */
    public function minScore(int | float $minScore): RequestBuilderInterface;

    /**
     * Allows to return a script evaluation (based on different fields) for each hit.
     */
    public function scriptField(string $fieldName, ScriptInterface $script): RequestBuilderInterface;

    /**
     * Allows to use the results from the previous page to help the retrieval of the next page.
     */
    public function searchAfter(array $values): RequestBuilderInterface;

    /**
     * The search timeout, bounding the search request to be executed within the given
     * time value and bail with the hits accumulated up to that point when expired.
     */
    public function timeout(int | string $timeout): RequestBuilderInterface;

    /**
     * The type of the search operation to perform.
     */
    public function searchType(string $type): RequestBuilderInterface;

    /**
     * The maximum number of documents to collect for each shard, upon reaching which the query execution will terminate early.
     */
    public function terminateAfter(int | string $numberOfDocs): RequestBuilderInterface;

    /**
     * When sorting on a field, scores are not computed. By setting track_scores to true, scores will still be computed and tracked.
     */
    public function trackScore(bool $status): RequestBuilderInterface;

    /**
     * Allows you to add a sort for a specific field.
     */
    public function sort(array | SortInterface $sort): RequestBuilderInterface;

    /**
     * Allows to control how the _source field is returned with every hit.
     */
    public function source(array | bool | string $source): RequestBuilderInterface;

    public function query(callable | QueryBuilderInterface $query): RequestBuilderInterface;

    public function aggregation(AggregationInterface $aggregation): RequestBuilderInterface;

    public function build(): array;
}
