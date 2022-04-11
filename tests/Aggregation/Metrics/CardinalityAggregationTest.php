<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Aggregation\Metrics;

use Hypefactors\ElasticBuilder\Aggregation\Metrics\CardinalityAggregation;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CardinalityAggregationTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $aggregation = new CardinalityAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');

        $expectedArray = [
            'genres' => [
                'cardinality' => [
                    'field' => 'genre',
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_can_set_a_precision_threshold()
    {
        $aggregation = new CardinalityAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->precision(100);

        $expectedArray = [
            'genres' => [
                'cardinality' => [
                    'field'               => 'genre',
                    'precision_threshold' => 100,
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_metadata_parameter()
    {
        $aggregation = new CardinalityAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->meta([
            'foo' => 'bar',
        ]);

        $expectedArray = [
            'genres' => [
                'cardinality' => [
                    'field' => 'genre',
                ],
                'meta' => [
                    'foo' => 'bar',
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_can_have_a_single_nested_aggregation()
    {
        $aggregation1 = new CardinalityAggregation();
        $aggregation1->name('genres');
        $aggregation1->field('genre');

        $aggregation2 = new CardinalityAggregation();
        $aggregation2->name('colors');
        $aggregation2->field('color');

        $aggregation1->aggregation($aggregation2);

        $expectedArray = [
            'genres' => [
                'cardinality' => [
                    'field' => 'genre',
                ],
                'aggs' => [
                    'colors' => [
                        'cardinality' => [
                            'field' => 'color',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation1->toArray());
    }

    /**
     * @test
     */
    public function it_can_have_multiple_nested_aggregation()
    {
        $aggregation1 = new CardinalityAggregation();
        $aggregation1->name('genres');
        $aggregation1->field('genre');

        $aggregation2 = new CardinalityAggregation();
        $aggregation2->name('colors_1');
        $aggregation2->field('color');

        $aggregation3 = new CardinalityAggregation();
        $aggregation3->name('colors_2');
        $aggregation3->field('color');

        $aggregation1->aggregations([$aggregation2, $aggregation3]);

        $expectedArray = [
            'genres' => [
                'cardinality' => [
                    'field' => 'genre',
                ],
                'aggs' => [
                    'colors_1' => [
                        'cardinality' => [
                            'field' => 'color',
                        ],
                    ],
                    'colors_2' => [
                        'cardinality' => [
                            'field' => 'color',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation1->toArray());
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_name_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The Aggregation "name" is required!');

        $aggregation = new CardinalityAggregation();
        $aggregation->toArray();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $aggregation = new CardinalityAggregation();
        $aggregation->name('genres');
        $aggregation->toArray();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_precision_is_above_the_max_value()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The maximum precision threslhold supported value is 40000!');

        $aggregation = new CardinalityAggregation();
        $aggregation->precision(40001);
    }
}
