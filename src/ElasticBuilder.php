<?php

namespace Hypefactors\ElasticBuilder;

use RuntimeException;
use Hypefactors\ElasticBuilder\Core\Sort;
use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Core\Script;
use Hypefactors\ElasticBuilder\Query\Query;
use Hypefactors\ElasticBuilder\Core\Highlight;
use Hypefactors\ElasticBuilder\Core\InnerHits;
use Hypefactors\ElasticBuilder\Aggregation\Aggregation;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-request-body.html
 */
class ElasticBuilder
{
    protected $body = [];

    protected $query = [];

    protected $aggregates = [];

    // protected $suggesters = [];

    public static function create()
    {
        return new static();
    }

    /**
     * Allows to return the doc value representation of a field for each hit.
     *
     * @param string      $field
     * @param string|null $format
     *
     * @return $this
     */
    public function docValueField(string $field, ?string $format = null): self
    {
        if (! isset($this->body['docvalue_fields'])) {
            $this->body['docvalue_fields'] = [];
        }

        if (! $format) {
            $body = $field;
        } else {
            $body = [
                'field'  => $field,
                'format' => $format,
            ];
        }

        $this->body['docvalue_fields'][] = $body;

        return $this;
    }

    /**
     * Enables or disables the explanation status for
     * each hit on how its score was computed.
     *
     * @param bool $status
     *
     * @return $this
     */
    public function explain(bool $status): self
    {
        $this->body['explain'] = $status;

        return $this;
    }

    /**
     * Allows to collapse search results based on field values. The collapsing
     * is done by selecting only the top sorted document per collapse key.
     *
     * @param string                                          $field
     * @param \Hypefactors\ElasticBuilder\Core\InnerHits|null $innerHits
     * @param int|null                                        $maxConcurrentGroupSearches
     *
     * @return $this
     */
    public function collapse(string $field, ?InnerHits $innerHits = null, ?int $maxConcurrentGroupSearches = null): self
    {
        $collapse = [
            'field' => $field,
        ];

        if ($innerHits) {
            $collapse['inner_hits'] = $innerHits->toArray();

            if ($maxConcurrentGroupSearches) {
                $collapse['max_concurrent_group_searches'] = $maxConcurrentGroupSearches;
            }
        }

        $this->body['collapse'] = $collapse;

        return $this;
    }

    /**
     * To retrieve hits from a certain offset.
     *
     * @param int|string $from
     *
     * @return $this
     */
    public function from($from): self
    {
        $this->body['from'] = $from;

        return $this;
    }

    /**
     * The number of hits to return.
     *
     * @param int|string $size
     *
     * @return $this
     */
    public function size($size): self
    {
        $this->body['size'] = $size;

        return $this;
    }

    /**
     * Allows to highlight search results on one or more fields.
     *
     * @param \Hypefactors\ElasticBuilder\Core\Highlight $highlight
     *
     * @return $this
     */
    public function highlight(Highlight $highlight): self
    {
        $this->body['highlight'] = $highlight;

        return $this;
    }

    /**
     * Exclude documents which have a "_score" less than the given minimum score.
     *
     * @param float|int $minScore
     *
     * @return $this
     */
    public function minScore($minScore): self
    {
        $this->body['min_score'] = $minScore;

        return $this;
    }

    /**
     * Allows to return a script evaluation (based on different fields) for each hit.
     *
     * @param string                                  $fieldName
     * @param \Hypefactors\ElasticBuilder\Core\Script $script
     *
     * @return $this
     */
    public function scriptField(string $fieldName, Script $script): self
    {
        if (! isset($this->body['script_fields'])) {
            $this->body['script_fields'] = [];
        }

        $this->body['script_fields'][$fieldName] = $script;

        return $this;
    }

    /**
     * Allows to use the results from the previous page to help the retrieval of the next page.
     *
     * @param array $values
     *
     * @return $this
     */
    public function searchAfter(array $values): self
    {
        $this->body['search_after'] = $values;

        return $this;
    }

    /**
     * The search timeout, bounding the search request to be executed within the given
     * time value and bail with the hits accumulated up to that point when expired.
     *
     * @param int|string $timeout
     *
     * @return $this
     */
    public function timeout($timeout): self
    {
        $this->body['timeout'] = $timeout;

        return $this;
    }

    /**
     * The type of the search operation to perform.
     *
     * @param string $type
     *
     * @return $this
     */
    public function searchType(string $type): self
    {
        $typeLower = strtolower($type);

        $validTypes = ['dfs_query_then_fetch', 'query_then_fetch'];

        if (! in_array($typeLower, $validTypes)) {
            throw new RuntimeException("The [{$type}] type is not valid!");
        }

        $this->body['search_type'] = $typeLower;

        return $this;
    }

    /**
     * The maximum number of documents to collect for each shard, upon reaching which the query execution will terminate early.
     *
     * @param int|string $numberOfDocs
     *
     * @return $this
     */
    public function terminateAfter($numberOfDocs): self
    {
        $this->body['terminate_after'] = $numberOfDocs;

        return $this;
    }

    /**
     * Allows you to add a sort for a specific field.
     *
     * @param \Hypefactors\ElasticBuilder\Core\Sort $sort
     *
     * @return $this
     */
    public function sort(Sort $sort): self
    {
        if (! isset($this->body['sort'])) {
            $this->body['sort'] = [];
        }

        $this->body['sort'][] = $sort;

        return $this;
    }

    /**
     * Allows you to add one or more sorts on specific fields.
     *
     * @param array $sorts
     *
     * @return $this
     */
    public function sorts(array $sorts): self
    {
        foreach ($sorts as $sort) {
            $this->sort($sort);
        }

        return $this;
    }

    /**
     * Allows to control how the _source field is returned with every hit.
     *
     * @param array|bool|string $source
     *
     * @return $this
     */
    public function source($source): self
    {
        $this->body['source'] = $source;

        return $this;
    }

    public function aggregation(Aggregation $aggregation): self
    {
        $this->aggregates += $aggregation->toArray();

        return $this;
    }

    public function query(Query $query): self
    {
        $this->query += $query->toArray();

        return $this;
    }

    /**
     * Returns the DSL Query as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $response = $this->body;

        if (! empty($this->query)) {
            $response['query'] = $this->query;
        }

        if (! empty($this->aggregates)) {
            $response['aggs'] = $this->aggregates;
        }

        // if (! empty($this->suggesters)) {
        //     $response['suggest'] = $this->suggesters;
        // }

        return Util::recursivetoArray($response);
    }

    /**
     * Returns the query in JSON format.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
