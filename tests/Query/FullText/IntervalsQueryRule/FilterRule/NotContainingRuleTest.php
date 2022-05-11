<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalsQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule\NotContainingRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\MatchRule;
use PHPUnit\Framework\TestCase;

class NotContainingRuleTest extends TestCase
{
    /**
     * @test
     */
    public function test()
    {
        $query = new NotContainingRule();
        $query->match(function (MatchRule $query) {
            $query->query('foo');
        });

        $expected = [
            'not_containing' => [
                'match' => [
                    'query' => 'foo',
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
