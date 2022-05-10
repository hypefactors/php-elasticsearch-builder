<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Compound;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;
use Hypefactors\ElasticBuilder\Query\QueryInterface;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-boosting-query.html
 */
class BoostingQuery extends Query implements BoostingQueryInterface
{
    public function positive(QueryInterface $query): BoostingQueryInterface
    {
        $this->body['positive'] = $query;

        return $this;
    }

    public function negative(QueryInterface $query): BoostingQueryInterface
    {
        $this->body['negative'] = $query;

        return $this;
    }

    public function negativeBoost(int | float $factor): BoostingQueryInterface
    {
        $this->body['negative_boost'] = $factor;

        return $this;
    }

    public function build(): array
    {
        if (empty($this->body)) {
            return [];
        }

        if (! isset($this->body['positive'])) {
            throw new InvalidArgumentException('The "positive" query is required!');
        }

        if (! isset($this->body['negative'])) {
            throw new InvalidArgumentException('The "negative" query is required!');
        }

        if (! isset($this->body['negative_boost'])) {
            throw new InvalidArgumentException('The "negative_boost" query is required!');
        }

        return [
            'boosting' => Util::recursivetoArray($this->body),
        ];
    }
}
