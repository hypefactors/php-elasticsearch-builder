<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\TermLevel\ExistsQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ExistsQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $query = new ExistsQuery();
        $query->field('my_field');

        $expectedArray = [
            'exists' => [
                'field' => 'my_field',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "exists": {
                    "field": "my_field"
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
        $query = new ExistsQuery();
        $query->field('my_field');
        $query->boost(1.5);

        $expectedArray = [
            'exists' => [
                'field' => 'my_field',
                'boost' => 1.5,
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "exists": {
                    "field": "my_field",
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
        $query = new ExistsQuery();
        $query->field('my_field');
        $query->name('my-query-name');

        $expectedArray = [
            'exists' => [
                'field' => 'my_field',
                '_name' => 'my-query-name',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "exists": {
                    "field": "my_field",
                    "_name": "my-query-name"
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

        $query = new ExistsQuery();

        $query->toArray();
    }
}
