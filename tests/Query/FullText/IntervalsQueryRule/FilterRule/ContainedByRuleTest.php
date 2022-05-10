<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalsQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule\ContainedByRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\MatchRule;
use PHPUnit\Framework\TestCase;

class ContainedByRuleTest extends TestCase
{
    /**
     * @test
     */
    public function test()
    {
        $query = new ContainedByRule();
        $query->match(function (MatchRule $query) {
            $query->query('foo');
        });

        $expected = [
            'contained_by' => [
                'match' => [
                    'query' => 'foo',
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
