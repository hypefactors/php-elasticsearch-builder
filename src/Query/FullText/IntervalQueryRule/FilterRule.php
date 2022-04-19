<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule\AfterRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule\BeforeRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule\ContainedByRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule\ContainingRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule\NotContainedByRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule\NotContainingRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule\NotOverlappingRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule\OverlappingRule;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-intervals-query.html#interval_filter
 */
final class FilterRule extends Query
{
    public function after(callable $callable): self
    {
        $afterRule = new AfterRule();

        $callable($afterRule);

        $this->body += $afterRule->toArray();

        return $this;
    }

    public function before(callable $callable): self
    {
        $beforeRule = new BeforeRule();

        $callable($beforeRule);

        $this->body += $beforeRule->toArray();

        return $this;
    }

    public function containedBy(callable $callable): self
    {
        $containedByRule = new ContainedByRule();

        $callable($containedByRule);

        $this->body += $containedByRule->toArray();

        return $this;
    }

    public function containing(callable $callable): self
    {
        $containingRule = new ContainingRule();

        $callable($containingRule);

        $this->body += $containingRule->toArray();

        return $this;
    }

    public function notContainedBy(callable $callable): self
    {
        $notContainedByRule = new NotContainedByRule();

        $callable($notContainedByRule);

        $this->body += $notContainedByRule->toArray();

        return $this;
    }

    public function notContaining(callable $callable): self
    {
        $notContainingRule = new NotContainingRule();

        $callable($notContainingRule);

        $this->body += $notContainingRule->toArray();

        return $this;
    }

    public function notOverlapping(callable $callable): self
    {
        $notOverlappingRule = new NotOverlappingRule();

        $callable($notOverlappingRule);

        $this->body += $notOverlappingRule->toArray();

        return $this;
    }

    public function overlapping(callable $callable): self
    {
        $overlappingRule = new OverlappingRule();

        $callable($overlappingRule);

        $this->body += $overlappingRule->toArray();

        return $this;
    }

    // TODO: Add script rule

    public function toArray(): array
    {
        return [
            'filter' => Util::recursivetoArray($this->body),
        ];
    }
}
