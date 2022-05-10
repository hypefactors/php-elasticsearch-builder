<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Core\Util;

class ContainedByRule extends BaseFilterRule
{
    public function build(): array
    {
        return [
            'contained_by' => Util::recursivetoArray($this->body),
        ];
    }
}
