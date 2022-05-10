<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalsQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule\BeforeRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\MatchRule;
use PHPUnit\Framework\TestCase;

class BeforeRuleTest extends TestCase
{
    /**
     * @test
     */
    public function test()
    {
        $query = new BeforeRule();
        $query->match(function (MatchRule $query) {
            $query->query('foo');
        });

        $expected = [
            'before' => [
                'match' => [
                    'query' => 'foo',
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
