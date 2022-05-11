<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule\AfterRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule\BeforeRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule\ContainedByRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule\ContainingRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule\NotContainedByRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule\NotContainingRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule\NotOverlappingRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule\OverlappingRule;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-intervals-query.html#interval_filter
 */
class FilterRule extends Query
{
    // TODO: Disallow "boost" and "name" methods

    public function after(callable | AfterRule $value): self
    {
        if (is_callable($value)) {
            $afterRule = new AfterRule();

            $value($afterRule);

            return $this->after($afterRule);
        }

        $this->body += $value->build();

        return $this;
    }

    public function before(callable | BeforeRule $value): self
    {
        if (is_callable($value)) {
            $beforeRule = new BeforeRule();

            $value($beforeRule);

            return $this->before($beforeRule);
        }

        $this->body += $value->build();

        return $this;
    }

    public function containedBy(callable | ContainedByRule $value): self
    {
        if (is_callable($value)) {
            $containedByRule = new ContainedByRule();

            $value($containedByRule);

            return $this->containedBy($containedByRule);
        }

        $this->body += $value->build();

        return $this;
    }

    public function containing(callable | ContainingRule $value): self
    {
        if (is_callable($value)) {
            $containingRule = new ContainingRule();

            $value($containingRule);

            return $this->containing($containingRule);
        }

        $this->body += $value->build();

        return $this;
    }

    public function notContainedBy(callable | NotContainedByRule $value): self
    {
        if (is_callable($value)) {
            $notContainedByRule = new NotContainedByRule();

            $value($notContainedByRule);

            return $this->notContainedBy($notContainedByRule);
        }

        $this->body += $value->build();

        return $this;
    }

    public function notContaining(callable | NotContainingRule $value): self
    {
        if (is_callable($value)) {
            $notContainingRule = new NotContainingRule();

            $value($notContainingRule);

            return $this->notContaining($notContainingRule);
        }

        $this->body += $value->build();

        return $this;
    }

    public function notOverlapping(callable | NotOverlappingRule $value): self
    {
        if (is_callable($value)) {
            $notOverlappingRule = new NotOverlappingRule();

            $value($notOverlappingRule);

            return $this->notOverlapping($notOverlappingRule);
        }

        $this->body += $value->build();

        return $this;
    }

    public function overlapping(callable | OverlappingRule $value): self
    {
        if (is_callable($value)) {
            $overlappingRule = new OverlappingRule();

            $value($overlappingRule);

            return $this->overlapping($overlappingRule);
        }

        $this->body += $value->build();

        return $this;
    }

    // TODO: Add script rule

    public function build(): array
    {
        return [
            'filter' => Util::recursivetoArray($this->body),
        ];
    }
}
