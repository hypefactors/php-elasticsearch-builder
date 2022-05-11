<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Core\Util;

class NotContainingRule extends BaseFilterRule
{
    public function build(): array
    {
        return [
            'not_containing' => Util::recursivetoArray($this->body),
        ];
    }
}
