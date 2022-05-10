<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalsQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule\NotOverlappingRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\MatchRule;
use PHPUnit\Framework\TestCase;

class NotOverlappingRuleTest extends TestCase
{
    /**
     * @test
     */
    public function test()
    {
        $query = new NotOverlappingRule();
        $query->match(function (MatchRule $query) {
            $query->query('foo');
        });

        $expected = [
            'not_overlapping' => [
                'match' => [
                    'query' => 'foo',
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
