<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText;

use Hypefactors\ElasticBuilder\Query\FullText\MatchQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MatchQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');

        $expectedArray = [
            'match' => [
                'message' => 'this is a test',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match": {
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
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->boost(1.5);

        $expectedArray = [
            'match' => [
                'message' => [
                    'query' => 'this is a test',
                    'boost' => 1.5,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match": {
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
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->name('my-query-name');

        $expectedArray = [
            'match' => [
                'message' => [
                    'query' => 'this is a test',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match": {
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
    public function it_builds_the_query_with_the_cut_off_frequency_parameter()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->cutOffFrequency(0.001);

        $expectedArray = [
            'match' => [
                'message' => [
                    'query'            => 'this is a test',
                    'cutoff_frequency' => 0.001,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match": {
                    "message": {
                        "query": "this is a test",
                        "cutoff_frequency": 0.001
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
    public function it_builds_the_query_with_the_fuziness_parameter()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->fuzziness(2);

        $expectedArray = [
            'match' => [
                'message' => [
                    'query'     => 'this is a test',
                    'fuzziness' => 2,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match": {
                    "message": {
                        "query": "this is a test",
                        "fuzziness": 2
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
    public function it_builds_the_query_with_the_lenient()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->lenient(true);

        $expectedArray = [
            'match' => [
                'message' => [
                    'query'   => 'this is a test',
                    'lenient' => true,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match": {
                    "message": {
                        "query": "this is a test",
                        "lenient": true
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
    public function it_builds_the_query_with_the_max_expansinons_parameter()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->maxExpansions(5);

        $expectedArray = [
            'match' => [
                'message' => [
                    'query'          => 'this is a test',
                    'max_expansions' => 5,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match": {
                    "message": {
                        "query": "this is a test",
                        "max_expansions": 5
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
    public function it_builds_the_query_with_the_prefix_length_parameter()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->prefixLength(5);

        $expectedArray = [
            'match' => [
                'message' => [
                    'query'         => 'this is a test',
                    'prefix_length' => 5,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match": {
                    "message": {
                        "query": "this is a test",
                        "prefix_length": 5
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
    public function it_builds_the_query_with_the_operator()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->operator('and');

        $expectedArray = [
            'match' => [
                'message' => [
                    'query'    => 'this is a test',
                    'operator' => 'and',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match": {
                    "message": {
                        "query": "this is a test",
                        "operator": "and"
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
    public function an_exception_will_be_thrown_when_passing_an_invalid_operator()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [foo] operator is invalid.');

        $query = new MatchQuery();
        $query->operator('foo');
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new MatchQuery();
        $query->toArray();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_query_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "query" is required!');

        $query = new MatchQuery();
        $query->field('message');

        $query->toArray();
    }
}
