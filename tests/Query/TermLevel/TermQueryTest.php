<?php

declare(strict_types=1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;

class TermQueryTest extends TestCase
{
    /** @test */
    public function it_builds_the_query()
    {
        $query = new TermQuery();
        $query->field('user');
        $query->value('john');

        $expectedArray = [
            'term' => [
                'user' => 'john',
            ],
        ];

        $expectedJson = <<<JSON
{
    "term": {
        "user": "john"
    }
}
JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_with_the_boost_factor_parameter()
    {
        $query = new TermQuery();
        $query->field('user');
        $query->value('john');
        $query->boost(1.5);

        $expectedArray = [
            'term' => [
                'user' => [
                    'value' => 'john',
                    'boost' => 1.5,
                ],
            ],
        ];

        $expectedJson = <<<JSON
{
    "term": {
        "user": {
            "value": "john",
            "boost": 1.5
        }
    }
}
JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_with_the_name_parameter()
    {
        $query = new TermQuery();
        $query->field('user');
        $query->value('john');
        $query->name('my-query-name');

        $expectedArray = [
            'term' => [
                'user' => [
                    'value' => 'john',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $expectedJson = <<<JSON
{
    "term": {
        "user": {
            "value": "john",
            "_name": "my-query-name"
        }
    }
}
JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new TermQuery();
        $query->toArray();
    }

    /** @test */
    public function an_exception_will_be_thrown_if_the_value_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "value" is required!');

        $query = new TermQuery();
        $query->field('user');

        $query->toArray();
    }
}
