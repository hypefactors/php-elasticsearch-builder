<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Core\Util;

class NotContainedByRule extends BaseFilterRule
{
    public function build(): array
    {
        return [
            'not_contained_by' => Util::recursivetoArray($this->body),
        ];
    }
}
