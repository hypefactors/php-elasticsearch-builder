<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Core\Util;

final class AfterRule extends BaseFilterRule
{
    public function toArray(): array
    {
        return [
            'after' => Util::recursivetoArray($this->body),
        ];
    }
}
