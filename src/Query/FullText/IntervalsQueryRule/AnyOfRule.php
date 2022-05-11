<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQuery;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-intervals-query.html#intervals-any_of
 */
class AnyOfRule extends Query
{
    // TODO: Disallow "boost" and "name" methods

    public function intervals(callable | IntervalsQuery $value): self
    {
        if (is_callable($value)) {
            $intervalsQuery = new IntervalsQuery();

            $value($intervalsQuery);

            return $this->intervals($intervalsQuery);
        }

        $value->setRequiresField(false);

        $this->body += $value->build();

        return $this;
    }

    public function filter(callable | FilterRule $value): self
    {
        if (is_callable($value)) {
            $filterRule = new FilterRule();

            $value($filterRule);

            return $this->filter($filterRule);
        }

        $this->body += $value->build();

        return $this;
    }

    public function build(): array
    {
        return [
            'any_of' => Util::recursivetoArray($this->body),
        ];
    }
}
