<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalQueryRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule\BeforeRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\MatchRule;
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

        $expectedArray = [
            'before' => [
                'match' => [
                    'query' => 'foo',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "before": {
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
