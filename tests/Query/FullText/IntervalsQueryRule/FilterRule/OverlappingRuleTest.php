<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalsQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule\OverlappingRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\MatchRule;
use PHPUnit\Framework\TestCase;

class OverlappingRuleTest extends TestCase
{
    /**
     * @test
     */
    public function test()
    {
        $query = new OverlappingRule();
        $query->match(function (MatchRule $query) {
            $query->query('foo');
        });

        $expected = [
            'overlapping' => [
                'match' => [
                    'query' => 'foo',
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
