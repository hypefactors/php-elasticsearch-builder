<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalQueryRule\FilterRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule\NotContainedByRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\MatchRule;
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

        $expectedArray = [
            'not_contained_by' => [
                'match' => [
                    'query' => 'foo',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "not_contained_by": {
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
