<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQuery;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-intervals-query.html#intervals-all_of
 */
class AllOfRule extends Query
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
            'all_of' => Util::recursivetoArray($this->body),
        ];
    }
}
