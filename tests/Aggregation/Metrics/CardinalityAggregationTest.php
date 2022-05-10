<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Aggregation\Metrics;

use Hypefactors\ElasticBuilder\Aggregation\Metrics\CardinalityAggregation;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;
use InvalidArgumentException;
use RuntimeException;

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

        $requestBuilder = new RequestBuilder();
        $requestBuilder->aggregation($aggregation);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'genres' => [
                'cardinality' => [
                    'field' => 'genre',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertSame($expected, $aggregation->build());
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

        $requestBuilder = new RequestBuilder();
        $requestBuilder->aggregation($aggregation);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'genres' => [
                'cardinality' => [
                    'field'               => 'genre',
                    'precision_threshold' => 100,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertSame($expected, $aggregation->build());
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

        $requestBuilder = new RequestBuilder();
        $requestBuilder->aggregation($aggregation);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'genres' => [
                'cardinality' => [
                    'field' => 'genre',
                ],
                'meta' => [
                    'foo' => 'bar',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertSame($expected, $aggregation->build());
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_when_using_sub_aggregations()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Cardinality Aggregations do not support sub-aggregations');

        $aggregation1 = new CardinalityAggregation();
        $aggregation1->name('genres');
        $aggregation1->field('genre');

        $aggregation2 = new CardinalityAggregation();
        $aggregation2->name('colors');
        $aggregation2->field('color');

        $aggregation1->aggregation($aggregation2);

        $requestBuilder = (new RequestBuilder())
            ->aggregation($aggregation1)
        ;

        $this->client->search($requestBuilder->build());
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_name_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The Aggregation "name" is required!');

        $aggregation = new CardinalityAggregation();
        $aggregation->build();
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
        $aggregation->build();
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
