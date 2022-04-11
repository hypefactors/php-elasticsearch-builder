<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\TermLevel\WildcardQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class WildcardQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $query = new WildcardQuery();
        $query->field('user');
        $query->value('john');

        $expectedArray = [
            'wildcard' => [
                'user' => 'john',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "wildcard": {
                    "user": "john"
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
        $query = new WildcardQuery();
        $query->field('user');
        $query->value('john');
        $query->boost(1.5);

        $expectedArray = [
            'wildcard' => [
                'user' => [
                    'value' => 'john',
                    'boost' => 1.5,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "wildcard": {
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

    /**
     * @test
     */
    public function it_builds_the_query_with_the_name_parameter()
    {
        $query = new WildcardQuery();
        $query->field('user');
        $query->value('john');
        $query->name('my-query-name');

        $expectedArray = [
            'wildcard' => [
                'user' => [
                    'value' => 'john',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "wildcard": {
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

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new WildcardQuery();
        $query->toArray();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_value_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "value" is required!');

        $query = new WildcardQuery();
        $query->field('user');

        $query->toArray();
    }
}
