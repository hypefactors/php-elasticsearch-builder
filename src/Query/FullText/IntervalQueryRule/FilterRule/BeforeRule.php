<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Core\Util;

final class BeforeRule extends BaseFilterRule
{
    public function toArray(): array
    {
        return [
            'before' => Util::recursivetoArray($this->body),
        ];
    }
}
