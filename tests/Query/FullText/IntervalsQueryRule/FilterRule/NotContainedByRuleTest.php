<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalsQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule\NotContainedByRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\MatchRule;
use PHPUnit\Framework\TestCase;

class NotContainedByRuleTest extends TestCase
{
    /**
     * @test
     */
    public function test()
    {
        $query = new NotContainedByRule();
        $query->match(function (MatchRule $query) {
            $query->query('foo');
        });

        $expected = [
            'not_contained_by' => [
                'match' => [
                    'query' => 'foo',
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
