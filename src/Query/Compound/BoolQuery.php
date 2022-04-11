<?php

namespace Hypefactors\ElasticBuilder\Query\Compound;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-bool-query.html
 */
class BoolQuery extends Query
{
    protected $queries = [];

    public function filter($queries): self
    {
        $this->addQueries('filter', $queries);

        return $this;
    }

    public function must($queries): self
    {
        $this->addQueries('must', $queries);

        return $this;
    }

    public function mustNot($queries): self
    {
        $this->addQueries('must_not', $queries);

        return $this;
    }

    public function should($queries): self
    {
        $this->addQueries('should', $queries);

        return $this;
    }

    public function minimumShouldMatch($minimumShouldMatch): self
    {
        $this->body['minimum_should_match'] = $minimumShouldMatch;

        return $this;
    }

    /**
     * Returns the DSL Query as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $validClauseKeys = ['must', 'filter', 'must_not', 'should'];

        $body = [];

        foreach ($this->queries as $clause => $queries) {
            if (in_array($clause, $validClauseKeys, true)) {
                if (count($queries) === 1) {
                    $body[$clause] = $queries[0]->toArray();
                } else {
                    foreach ($queries as $query) {
                        $body[$clause][] = $query->toArray();
                    }
                }
            }
        }

        return [
            'bool' => array_merge($body, $this->body),
        ];
    }

    protected function addQuery(string $clause, Query $query)
    {
        $this->queries[$clause][] = $query;

        return $this;
    }

    protected function addQueries(string $clause, $queries)
    {
        foreach (Util::arrayWrap($queries) as $query) {
            $this->addQuery($clause, $query);
        }

        return $this;
    }
}
