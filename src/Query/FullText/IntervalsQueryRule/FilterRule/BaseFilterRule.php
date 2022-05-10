<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\MatchRule;
use Hypefactors\ElasticBuilder\Query\Query;

abstract class BaseFilterRule extends Query
{
    // TODO: Disallow "boost" and "name" methods

    public function match(callable | MatchRule $value): self
    {
        if (is_callable($value)) {
            $matchRule = new MatchRule();

            $value($matchRule);

            return $this->match($matchRule);
        }

        $this->body += $value->build();

        return $this;
    }
}
