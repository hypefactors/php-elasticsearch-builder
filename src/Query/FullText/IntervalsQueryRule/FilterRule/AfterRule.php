<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Core\Util;

class AfterRule extends BaseFilterRule
{
    public function build(): array
    {
        return [
            'after' => Util::recursivetoArray($this->body),
        ];
    }
}
