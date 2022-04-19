<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQuery;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-intervals-query.html#intervals-all_of
 */
final class AllOfRule extends Query /* implements IntervalQueryRuleInterface */
{
    public function intervals(callable | IntervalsQuery $callable): self
    {
        if (is_callable($callable)) {
            $intervalsQuery = new IntervalsQuery();

            $callable($intervalsQuery);

            $this->body += $intervalsQuery->toArray();
        } else {
            $this->body += $callable->toArray();
        }

        return $this;
    }

    public function maxGaps(int $maxGaps): self
    {
        $this->body['max_gaps'] = $maxGaps;

        return $this;
    }

    public function ordered(bool $status): self
    {
        $this->body['ordered'] = $status;

        return $this;
    }

    public function filter(callable | FilterRule $callable): self
    {
        if (is_callable($callable)) {
            $filterRule = new FilterRule();

            $callable($filterRule);

            $this->body += $filterRule->toArray();
        } else {
            $this->body += $callable->toArray();
        }

        return $this;
    }

    public function toArray(): array
    {
        return [
            'all_of' => Util::recursivetoArray($this->body),
        ];
    }
}
