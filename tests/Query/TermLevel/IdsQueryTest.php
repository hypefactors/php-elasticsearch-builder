<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\TermLevel\IdsQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class IdsQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query_without_type_parameter()
    {
        $query = new IdsQuery();
        $query->values(['1', '4', '10']);

        $expectedArray = [
            'ids' => [
                'values' => ['1', '4', '10'],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "ids": {
                    "values": [
                        "1",
                        "4",
                        "10"
                    ]
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_type_parameter()
    {
        $query = new IdsQuery();
        $query->type('_doc');
        $query->values(['1', '4', '10']);

        $expectedArray = [
            'ids' => [
                'type'   => '_doc',
                'values' => ['1', '4', '10'],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "ids": {
                    "type": "_doc",
                    "values": [
                        "1",
                        "4",
                        "10"
                    ]
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
        $query = new IdsQuery();
        $query->values(['1', '4', '10']);
        $query->boost(1.5);

        $expectedArray = [
            'ids' => [
                'values' => ['1', '4', '10'],
                'boost'  => 1.5,
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "ids": {
                    "values": [
                        "1",
                        "4",
                        "10"
                    ],
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
        $query = new IdsQuery();
        $query->values(['1', '4', '10']);
        $query->name('my-query-name');

        $expectedArray = [
            'ids' => [
                'values' => ['1', '4', '10'],
                '_name'  => 'my-query-name',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "ids": {
                    "values": [
                        "1",
                        "4",
                        "10"
                    ],
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
    public function an_exception_will_be_thrown_if_the_values_are_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "values" are required!');

        $query = new IdsQuery();
        $query->toArray();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_are_set_but_they_are_empty_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "values" cannot be empty!');

        $query = new IdsQuery();
        $query->values([]);

        $query->toArray();
    }
}
