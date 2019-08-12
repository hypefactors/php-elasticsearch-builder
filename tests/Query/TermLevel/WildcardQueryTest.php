<?php

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Query\TermLevel\WildcardQuery;

class WildcardQueryTest extends TestCase
{
    /** @test */
    public function it_builds_the_query_as_array()
    {
        $query = new WildcardQuery();
        $query->field('user');
        $query->value('john');

        $expectedQuery = [
            'wildcard' => [
                'user' => 'john',
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_boost_factor_parameter()
    {
        $query = new WildcardQuery();
        $query->field('user');
        $query->value('john');
        $query->boost(1.5);

        $expectedQuery = [
            'wildcard' => [
                'user' => [
                    'value' => 'john',
                    'boost' => 1.5,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_name_parameter()
    {
        $query = new WildcardQuery();
        $query->field('user');
        $query->value('john');
        $query->name('my-query-name');

        $expectedQuery = [
            'wildcard' => [
                'user' => [
                    'value' => 'john',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_json()
    {
        $query = new WildcardQuery();
        $query->field('user');
        $query->value('john');

        $expectedQuery = <<<JSON
{
    "wildcard": {
        "user": "john"
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_boost_factor_parameter()
    {
        $query = new WildcardQuery();
        $query->field('user');
        $query->value('john');
        $query->boost(1.5);

        $expectedQuery = <<<JSON
{
    "wildcard": {
        "user": {
            "value": "john",
            "boost": 1.5
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_name_parameter()
    {
        $query = new WildcardQuery();
        $query->field('user');
        $query->value('john');
        $query->name('my-query-name');

        $expectedQuery = <<<JSON
{
    "wildcard": {
        "user": {
            "value": "john",
            "_name": "my-query-name"
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new WildcardQuery();
        $query->toArray();
    }

    /** @test */
    public function an_exception_will_be_thrown_if_the_value_is_not_set_when_building_the_query()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The "value" is required!');

        $query = new WildcardQuery();
        $query->field('user');

        $query->toArray();
    }
}
