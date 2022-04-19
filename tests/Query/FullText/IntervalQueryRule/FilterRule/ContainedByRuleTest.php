<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalQueryRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule\ContainedByRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\MatchRule;
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

        $expectedArray = [
            'contained_by' => [
                'match' => [
                    'query' => 'foo',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "contained_by": {
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
