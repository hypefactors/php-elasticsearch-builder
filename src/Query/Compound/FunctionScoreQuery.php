<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Compound;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Compound\ScoreFunctions\ScoreFunction;
use Hypefactors\ElasticBuilder\Query\Query;
use Hypefactors\ElasticBuilder\Query\QueryInterface;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-function-score-query.html
 */
class FunctionScoreQuery extends Query
{
    public function query(QueryInterface $query): self
    {
        $this->body['query'] = $query;

        return $this;
    }

    public function scoreMode(string $mode): self
    {
        $modeLower = strtolower($mode);

        $validModes = ['multiply', 'sum', 'avg', 'first', 'max', 'min'];

        if (! in_array($modeLower, $validModes, true)) {
            throw new InvalidArgumentException("The [{$mode}] mode is invalid.");
        }

        $this->body['score_mode'] = $modeLower;

        return $this;
    }

    public function boostMode(string $mode): self
    {
        $modeLower = strtolower($mode);

        $validModes = ['multiply', 'replace', 'sum', 'avg', 'max', 'min'];

        if (! in_array($modeLower, $validModes, true)) {
            throw new InvalidArgumentException("The [{$mode}] mode is invalid.");
        }

        $this->body['boost_mode'] = $modeLower;

        return $this;
    }

    public function maxBoost($limit): self
    {
        $this->body['max_boost'] = $limit;

        return $this;
    }

    public function minScore($limit): self
    {
        $this->body['min_score'] = $limit;

        return $this;
    }

    public function function(ScoreFunction $function): self
    {
        $this->body['functions'][] = $function;

        return $this;
    }

    public function functions(array $functions): self
    {
        foreach ($functions as $function) {
            $this->function($function);
        }

        return $this;
    }

    /**
     * Returns the DSL Query as an array.
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function toArray(): array
    {
        if (! isset($this->body['field'])) {
            throw new InvalidArgumentException('The "field" is required!');
        }

        return [
            'function_score' => Util::recursivetoArray($this->body),
        ];
    }
}
