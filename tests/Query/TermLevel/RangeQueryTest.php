<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\TermLevel\RangeQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RangeQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query_with_the_boost_factor_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->boost(1.5);

        $expectedArray = [
            'range' => [
                'user' => [
                    'boost' => 1.5,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "range": {
                    "user": {
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
        $query = new RangeQuery();
        $query->field('user');
        $query->name('my-query-name');

        $expectedArray = [
            'range' => [
                'user' => [
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "range": {
                    "user": {
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
    public function it_builds_the_query_with_the_less_than_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->lessThan(10);

        $expectedArray = [
            'range' => [
                'user' => [
                    'lt' => 10,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "range": {
                    "user": {
                        "lt": 10
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
    public function it_builds_the_query_with_the_less_than_or_equal_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->lessThanEquals(10);

        $expectedArray = [
            'range' => [
                'user' => [
                    'lte' => 10,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "range": {
                    "user": {
                        "lte": 10
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
    public function it_builds_the_query_with_the_greater_than_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->greaterThan(12);

        $expectedArray = [
            'range' => [
                'user' => [
                    'gt' => 12,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "range": {
                    "user": {
                        "gt": 12
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
    public function it_builds_the_query_with_the_greater_than_or_equal_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->greaterThanEquals(12);

        $expectedArray = [
            'range' => [
                'user' => [
                    'gte' => 12,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "range": {
                    "user": {
                        "gte": 12
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
    public function it_builds_the_query_with_the_format_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->format('yyyy-MM-dd');

        $expectedArray = [
            'range' => [
                'user' => [
                    'format' => 'yyyy-MM-dd',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "range": {
                    "user": {
                        "format": "yyyy-MM-dd"
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
    public function it_builds_the_query_with_the_relation_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->relation('INTERSECTS');

        $expectedArray = [
            'range' => [
                'user' => [
                    'relation' => 'INTERSECTS',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "range": {
                    "user": {
                        "relation": "INTERSECTS"
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
    public function it_builds_the_query_with_the_timezone_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->timezone('+01:00');

        $expectedArray = [
            'range' => [
                'user' => [
                    'time_zone' => '+01:00',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "range": {
                    "user": {
                        "time_zone": "+01:00"
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
    public function an_exception_will_be_thrown_when_setting_an_invalid_relation()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [foo] relation is invalid!');

        $query = new RangeQuery();
        $query->field('user');
        $query->relation('foo');
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new RangeQuery();
        $query->toArray();
    }
}
