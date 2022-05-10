<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Compound;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQuery;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\MustNotQuery;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\MustNotQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\MustQuery;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\MustQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\ShouldQuery;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\ShouldQueryInterface;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-bool-query.html
 */
class BoolQuery extends Query implements BoolQueryInterface
{
    private array $queries = [];

    public function filter(callable | FilterQueryInterface $value): BoolQueryInterface
    {
        if (is_callable($value)) {
            $filterQuery = new FilterQuery();

            $value($filterQuery);

            return $this->filter($filterQuery);
        }

        if (! $value->isEmpty()) {
            $this->queries['filter'][] = $value;
        }

        return $this;
    }

    public function must(callable | MustQueryInterface $value): BoolQueryInterface
    {
        if (is_callable($value)) {
            $mustQuery = new MustQuery();

            $value($mustQuery);

            return $this->must($mustQuery);
        }

        if (! $value->isEmpty()) {
            $this->queries['must'][] = $value;
        }

        return $this;
    }

    public function mustNot(callable | MustNotQueryInterface $value): BoolQueryInterface
    {
        if (is_callable($value)) {
            $mustNotQuery = new MustNotQuery();

            $value($mustNotQuery);

            return $this->mustNot($mustNotQuery);
        }

        if (! $value->isEmpty()) {
            $this->queries['must_not'][] = $value;
        }

        return $this;
    }

    public function should(callable | ShouldQueryInterface $value): BoolQueryInterface
    {
        if (is_callable($value)) {
            $shouldQuery = new ShouldQuery();

            $value($shouldQuery);

            return $this->should($shouldQuery);
        }

        if (! $value->isEmpty()) {
            $this->queries['should'][] = $value;
        }

        return $this;
    }

    public function minimumShouldMatch($minimumShouldMatch): BoolQueryInterface
    {
        $this->body['minimum_should_match'] = $minimumShouldMatch;

        return $this;
    }

    public function build(): array
    {
        $response = $this->body;

        foreach ($this->queries as $clause => $queries) {
            if (count($queries) === 1) {
                $response[$clause] = $queries[0]->build();
            } else {
                foreach ($queries as $query) {
                    $response[$clause][] = $query->build();
                }
            }
        }

        if (empty($response)) {
            return [];
        }

        return [
            'bool' => $response,
        ];
    }
}
