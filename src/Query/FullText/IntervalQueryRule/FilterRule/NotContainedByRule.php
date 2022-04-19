<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Core\Util;

final class NotContainedByRule extends BaseFilterRule
{
    public function toArray(): array
    {
        return [
            'not_contained_by' => Util::recursivetoArray($this->body),
        ];
    }
}
