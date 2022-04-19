<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\MatchRule;
use Hypefactors\ElasticBuilder\Query\Query;

abstract class BaseFilterRule extends Query
{
    public function match(callable | MatchRule $callable): self
    {
        if (is_callable($callable)) {
            $matchRule = new MatchRule();

            $callable($matchRule);

            $this->body += $matchRule->toArray();
        } else {
            $this->body += $callable->toArray();
        }

        return $this;
    }
}
