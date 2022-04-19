<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Core\Util;

final class OverlappingRule extends BaseFilterRule
{
    public function toArray(): array
    {
        return [
            'overlapping' => Util::recursivetoArray($this->body),
        ];
    }
}
