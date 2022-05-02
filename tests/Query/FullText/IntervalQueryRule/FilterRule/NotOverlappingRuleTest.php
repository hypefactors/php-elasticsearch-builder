<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule\NotOverlappingRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\MatchRule;
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

        $expectedArray = [
            'not_overlapping' => [
                'match' => [
                    'query' => 'foo',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "not_overlapping": {
                    "match": {
                        "query": "foo"
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }
}
