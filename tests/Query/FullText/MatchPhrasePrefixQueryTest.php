<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText;

use Hypefactors\ElasticBuilder\Query\FullText\MatchPhrasePrefixQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MatchPhrasePrefixQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $query = new MatchPhrasePrefixQuery();
        $query->field('message');
        $query->query('this is a test');

        $expectedArray = [
            'match_phrase_prefix' => [
                'message' => 'this is a test',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match_phrase_prefix": {
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
        $query = new MatchPhrasePrefixQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->boost(1.5);

        $expectedArray = [
            'match_phrase_prefix' => [
                'message' => [
                    'query' => 'this is a test',
                    'boost' => 1.5,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match_phrase_prefix": {
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
        $query = new MatchPhrasePrefixQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->name('my-query-name');

        $expectedArray = [
            'match_phrase_prefix' => [
                'message' => [
                    'query' => 'this is a test',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match_phrase_prefix": {
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
    public function it_builds_the_query_with_the_analyzer_parameter()
    {
        $query = new MatchPhrasePrefixQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->analyzer('something');

        $expectedArray = [
            'match_phrase_prefix' => [
                'message' => [
                    'query'    => 'this is a test',
                    'analyzer' => 'something',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match_phrase_prefix": {
                    "message": {
                        "query": "this is a test",
                        "analyzer": "something"
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
    public function it_builds_the_query_with_the_max_expansions_parameter()
    {
        $query = new MatchPhrasePrefixQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->maxExpansions(10);

        $expectedArray = [
            'match_phrase_prefix' => [
                'message' => [
                    'query'          => 'this is a test',
                    'max_expansions' => 10,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match_phrase_prefix": {
                    "message": {
                        "query": "this is a test",
                        "max_expansions": 10
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
        $query = new MatchPhrasePrefixQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->slop(10);

        $expectedArray = [
            'match_phrase_prefix' => [
                'message' => [
                    'query' => 'this is a test',
                    'slop'  => 10,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match_phrase_prefix": {
                    "message": {
                        "query": "this is a test",
                        "slop": 10
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
    public function it_builds_the_query_with_the_zero_terms_query_parameter()
    {
        $query = new MatchPhrasePrefixQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->zeroTermsQuery('all');

        $expectedArray = [
            'match_phrase_prefix' => [
                'message' => [
                    'query'            => 'this is a test',
                    'zero_terms_query' => 'all',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match_phrase_prefix": {
                    "message": {
                        "query": "this is a test",
                        "zero_terms_query": "all"
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
    public function an_exception_will_be_thrown_when_setting_an_invalid_zero_terms_query_status()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [foo] zero terms query status is invalid!');

        $query = new MatchPhrasePrefixQuery();
        $query->field('message');
        $query->zeroTermsQuery('foo');
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new MatchPhrasePrefixQuery();
        $query->toArray();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_query_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "query" is required!');

        $query = new MatchPhrasePrefixQuery();
        $query->field('message');

        $query->toArray();
    }
}
