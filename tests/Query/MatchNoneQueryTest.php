<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query;

use Hypefactors\ElasticBuilder\Query\MatchNoneQuery;
use PHPUnit\Framework\TestCase;

class MatchNoneQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $query = new MatchNoneQuery();

        $expectedArray = [
            'match_none' => [],
        ];

        $expectedJson = <<<'JSON'
            {
                "match_none": []
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_boost_factor_parameter()
    {
        $query = new MatchNoneQuery();
        $query->boost(1.5);

        $expectedArray = [
            'match_none' => [
                'boost' => 1.5,
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match_none": {
                    "boost": 1.5
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_name_parameter()
    {
        $query = new MatchNoneQuery();
        $query->name('my-query-name');

        $expectedArray = [
            'match_none' => [
                '_name' => 'my-query-name',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match_none": {
                    "_name": "my-query-name"
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }
}
