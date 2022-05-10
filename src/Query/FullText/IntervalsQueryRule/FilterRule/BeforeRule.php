<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Core\Util;

class BeforeRule extends BaseFilterRule
{
    public function build(): array
    {
        return [
            'before' => Util::recursivetoArray($this->body),
        ];
    }
}
