<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText;

use Hypefactors\ElasticBuilder\Query\FullText\MatchPhraseQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MatchPhraseQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $query = new MatchPhraseQuery();
        $query->field('message');
        $query->query('this is a test');

        $expectedArray = [
            'match_phrase' => [
                'message' => 'this is a test',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match_phrase": {
                    "message": "this is a test"
                }
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
        $query = new MatchPhraseQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->boost(1.5);

        $expectedArray = [
            'match_phrase' => [
                'message' => [
                    'query' => 'this is a test',
                    'boost' => 1.5,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match_phrase": {
                    "message": {
                        "query": "this is a test",
                        "boost": 1.5
                    }
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
        $query = new MatchPhraseQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->name('my-query-name');

        $expectedArray = [
            'match_phrase' => [
                'message' => [
                    'query' => 'this is a test',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match_phrase": {
                    "message": {
                        "query": "this is a test",
                        "_name": "my-query-name"
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_slop_parameter()
    {
        $query = new MatchPhraseQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->slop(5);

        $expectedArray = [
            'match_phrase' => [
                'message' => [
                    'query' => 'this is a test',
                    'slop'  => 5,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match_phrase": {
                    "message": {
                        "query": "this is a test",
                        "slop": 5
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new MatchPhraseQuery();
        $query->toArray();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_query_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "query" is required!');

        $query = new MatchPhraseQuery();
        $query->field('message');

        $query->toArray();
    }
}
