<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Core;

use Hypefactors\ElasticBuilder\Highlight\HighlightInterface;
use Hypefactors\ElasticBuilder\Sort\SortInterface;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-request-body.html#request-body-search-inner-hits
 */
final class InnerHits
{
    /**
     * The body response.
     *
     * @var array
     */
    protected $body = [];

    /**
     * The offset from where the first hit to fetch for each
     * inner_hits in the returned regular search hits.
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
     * The name to be used for the particular inner hit definition in the response.
     *
     * @param string $name
     *
     * @return $this
     */
    public function name(string $name): self
    {
        $this->body['name'] = $name;

        return $this;
    }

    /**
     * The maximum number of hits to return per inner_hits.
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
     * How the inner hits should be sorted per inner_hits.
     *
     * @param \Hypefactors\ElasticBuilder\Sort\SortInterface $sort
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

    public function sorts(array $sorts): self
    {
        foreach ($sorts as $sort) {
            $this->sort($sort);
        }

        return $this;
    }

    public function highlight(HighlightInterface $highlight): self
    {
        $this->body['highlight'] = $highlight;

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
     * Returns the DSL Query as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return Util::recursivetoArray($this->body);
    }
}
