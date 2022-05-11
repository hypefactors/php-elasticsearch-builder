<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Core;

interface InnerHitsInterface extends ArrayableInterface
{
    /**
     * The offset from where the first hit to fetch for each
     * inner_hits in the returned regular search hits.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/inner-hits.html#inner-hits-options
     */
    public function from(int | string $from): InnerHitsInterface;

    /**
     * The name to be used for the particular inner hit definition in the response.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/inner-hits.html#inner-hits-options
     */
    public function name(string $name): InnerHitsInterface;

    /**
     * The maximum number of hits to return per inner_hits.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/inner-hits.html#inner-hits-options
     */
    public function size(int | string $size): InnerHitsInterface;

    /**
     * How the inner hits should be sorted per inner_hits.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/sort-search-results.html
     */
    public function sort(callable | SortInterface $sort): InnerHitsInterface;

    /**
     * ...
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/highlighting.html
     */
    public function highlight(callable | HighlightInterface $value): InnerHitsInterface;

    /**
     * Enables explanation for each hit on how its score was computed.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-search.html#request-body-search-explain
     */
    public function explain(bool $status): InnerHitsInterface;

    /**
     * Allows to control how the _source field is returned with every hit.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-fields.html#source-filtering
     */
    public function source(array | bool | string $source): InnerHitsInterface;

    /**
     * ...
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-fields.html#script-fields
     */
    public function script(callable | ScriptInterface $value): InnerHitsInterface;

    /**
     * Allows to return the doc value representation of a field for each hit.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-fields.html#docvalue-fields
     */
    public function docValueField(string $field, string | null $format = null): InnerHitsInterface;

    /**
     * Returns a version for each search hit.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-search.html#request-body-search-version
     */
    public function version(bool $status): InnerHitsInterface;
}
