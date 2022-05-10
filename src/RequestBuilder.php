<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder;

use Hypefactors\ElasticBuilder\Aggregation\AggregationInterface;
use Hypefactors\ElasticBuilder\Core\Collapse;
use Hypefactors\ElasticBuilder\Core\CollapseInterface;
use Hypefactors\ElasticBuilder\Core\Highlight;
use Hypefactors\ElasticBuilder\Core\HighlightInterface;
use Hypefactors\ElasticBuilder\Core\ScriptInterface;
use Hypefactors\ElasticBuilder\Core\Sort;
use Hypefactors\ElasticBuilder\Core\SortInterface;
use Hypefactors\ElasticBuilder\Core\Util;
use InvalidArgumentException;

class RequestBuilder implements RequestBuilderInterface
{
    private array $response = [];

    private array $body = [];

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations.html
     */
    private array $aggregations = [];

    public function option(string $option, int | string | bool $value): RequestBuilderInterface
    {
        $this->response[$option] = $value;

        return $this;
    }

    public function options(array $options): RequestBuilderInterface
    {
        foreach ($options as $option => $value) {
            $this->option($option, $value);
        }

        return $this;
    }

    public function index(string $indexes): RequestBuilderInterface
    {
        $this->option('index', $indexes);

        return $this;
    }

    public function docValueField(string $field, string | null $format = null): RequestBuilderInterface
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

    public function explain(bool $status): RequestBuilderInterface
    {
        $this->body['explain'] = $status;

        return $this;
    }

    public function collapse(callable | CollapseInterface $value): RequestBuilderInterface
    {
        if (is_callable($value)) {
            $collapse = new Collapse();

            $value($collapse);

            return $this->collapse($collapse);
        }

        $this->body['collapse'] = $value;

        return $this;
    }

    public function from(int | string $from): RequestBuilderInterface
    {
        $this->body['from'] = $from;

        return $this;
    }

    public function size(int | string $size): RequestBuilderInterface
    {
        $this->body['size'] = $size;

        return $this;
    }

    public function highlight(callable | HighlightInterface $value): RequestBuilderInterface
    {
        if (is_callable($value)) {
            $highlight = new Highlight();

            $value($highlight);

            return $this->highlight($highlight);
        }

        $this->body['highlight'] = $value;

        return $this;
    }

    public function minScore(int | float $minScore): RequestBuilderInterface
    {
        $this->body['min_score'] = $minScore;

        return $this;
    }

    public function scriptField(string $fieldName, ScriptInterface $script): RequestBuilderInterface
    {
        if (! isset($this->body['script_fields'])) {
            $this->body['script_fields'] = [];
        }

        $this->body['script_fields'][$fieldName] = $script;

        return $this;
    }

    public function searchAfter(array $values): RequestBuilderInterface
    {
        if (! empty($values)) {
            $this->body['search_after'] = $values;
        }

        return $this;
    }

    public function timeout(int | string $timeout): RequestBuilderInterface
    {
        $this->body['timeout'] = $timeout;

        return $this;
    }

    public function searchType(string $type): RequestBuilderInterface
    {
        $typeLower = strtolower($type);

        $validTypes = ['dfs_query_then_fetch', 'query_then_fetch'];

        if (! in_array($typeLower, $validTypes, true)) {
            throw new InvalidArgumentException("The [{$type}] type is not valid!");
        }

        $this->body['search_type'] = $typeLower;

        return $this;
    }

    public function terminateAfter(int | string $numberOfDocs): RequestBuilderInterface
    {
        $this->body['terminate_after'] = $numberOfDocs;

        return $this;
    }

    public function trackScore(bool $status): RequestBuilderInterface
    {
        $this->body['track_scores'] = $status;

        return $this;
    }

    public function sort(array | SortInterface $sort): RequestBuilderInterface
    {
        if (is_array($sort)) {
            foreach ($sort as $field => $order) {
                $sort = new Sort($field, $order);

                $this->sort($sort);
            }

            return $this;
        }

        if (! isset($this->body['sort'])) {
            $this->body['sort'] = [];
        }

        $this->body['sort'][] = $sort;

        return $this;
    }

    public function source(array | bool | string $source): RequestBuilderInterface
    {
        if (! empty($source)) {
            $this->body['_source'] = $source;
        }

        return $this;
    }

    public function query(callable | QueryBuilderInterface $query): RequestBuilderInterface
    {
        if (is_callable($query)) {
            $queryBuilder = new QueryBuilder();

            $query($queryBuilder);

            return $this->query($queryBuilder);
        }

        if (! $query->isEmpty()) {
            $this->body['query'] = $query;
        }

        return $this;
    }

    public function aggregation(AggregationInterface $aggregation): RequestBuilderInterface
    {
        $this->aggregations += $aggregation->build();

        return $this;
    }

    public function build(): array
    {
        $response = $this->response;

        $body = $this->body;

        if (! empty($this->aggregations)) {
            $body['aggs'] = $this->aggregations;
        }

        if (! empty($body)) {
            $response['body'] = Util::recursivetoArray($body);
        }

        return $response;
    }
}
