<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Core\Util;

class ContainingRule extends BaseFilterRule
{
    public function build(): array
    {
        return [
            'containing' => Util::recursivetoArray($this->body),
        ];
    }
}
