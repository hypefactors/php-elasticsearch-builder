<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Core\Util;

class NotOverlappingRule extends BaseFilterRule
{
    public function build(): array
    {
        return [
            'not_overlapping' => Util::recursivetoArray($this->body),
        ];
    }
}
