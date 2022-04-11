<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query;

use Hypefactors\ElasticBuilder\Query\MatchAllQuery;
use PHPUnit\Framework\TestCase;

class MatchAllQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $query = new MatchAllQuery();

        $expectedArray = [
            'match_all' => [],
        ];

        $expectedJson = <<<'JSON'
            {
                "match_all": []
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
        $query = new MatchAllQuery();
        $query->boost(1.5);

        $expectedArray = [
            'match_all' => [
                'boost' => 1.5,
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match_all": {
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
        $query = new MatchAllQuery();
        $query->name('my-query-name');

        $expectedArray = [
            'match_all' => [
                '_name' => 'my-query-name',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match_all": {
                    "_name": "my-query-name"
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }
}
