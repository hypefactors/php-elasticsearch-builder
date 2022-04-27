<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Aggregation\Metrics;

use Hypefactors\ElasticBuilder\Aggregation\Aggregation;
use Hypefactors\ElasticBuilder\Core\ScriptInterface;
use Hypefactors\ElasticBuilder\Core\SortInterface;
use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Highlight\HighlightInterface;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-top-hits-aggregation.html
 */
class TopHitsAggregation extends Aggregation
{
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
     * Allows you to add a sort for a specific field.
     *
     * @param \Hypefactors\ElasticBuilder\Core\SortInterface $sort
     *
     * @return $this
     */
    public function sort(SortInterface $sort): self
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
     * When sorting on a field, scores are not computed. By setting track_scores to true, scores will still be computed and tracked.
     *
     * @param bool $status
     *
     * @return $this
     */
    public function trackScores(bool $status): self
    {
        $this->body['track_scores'] = $status;

        return $this;
    }

    /**
     * Returns a version for each search hit.
     *
     * @param bool $status
     *
     * @return $this
     */
    public function version(bool $status): self
    {
        $this->body['version'] = $status;

        return $this;
    }

    /**
     * Enables explanation for each hit on how its score was computed.
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
     * Allows to highlight search results on one or more fields.
     *
     * @param \Hypefactors\ElasticBuilder\Highlight\HighlightInterface $highlight
     *
     * @return $this
     */
    public function highlight(HighlightInterface $highlight): self
    {
        $this->body['highlight'] = $highlight;

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
        $this->body['_source'] = $source;

        return $this;
    }

    public function storedFields($fields): self
    {
        $this->body['stored_fields'] = $fields;

        return $this;
    }

    /**
     * Allows to return a script evaluation (based on different fields) for each hit.
     *
     * @param string                                           $fieldName
     * @param \Hypefactors\ElasticBuilder\Core\ScriptInterface $script
     *
     * @return $this
     */
    public function scriptField(string $fieldName, ScriptInterface $script): self
    {
        if (! isset($this->body['script_fields'])) {
            $this->body['script_fields'] = [];
        }

        $this->body['script_fields'][$fieldName] = $script;

        return $this;
    }

    // TODO: Add "scriptFields" <-- calls "scriptField" in a loop

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

    public function getBody(): array
    {
        if (! isset($this->body['field'])) {
            throw new InvalidArgumentException('The "field" is required!');
        }

        return [
            'top_hits' => Util::recursivetoArray($this->body),
        ];
    }
}
