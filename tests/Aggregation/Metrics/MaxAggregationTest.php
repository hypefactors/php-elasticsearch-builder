<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Aggregation\Metrics;

use Hypefactors\ElasticBuilder\Aggregation\Metrics\MaxAggregation;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;
use InvalidArgumentException;
use RuntimeException;

class MaxAggregationTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $aggregation = new MaxAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->aggregation($aggregation);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'genres' => [
                'max' => [
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
    public function it_builds_the_query_with_the_metadata_parameter()
    {
        $aggregation = new MaxAggregation();
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
                'max' => [
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
        $this->expectExceptionMessage('Max Aggregations do not support sub-aggregations');

        $aggregation1 = new MaxAggregation();
        $aggregation1->name('genres');
        $aggregation1->field('genre');

        $aggregation2 = new MaxAggregation();
        $aggregation2->name('colors');
        $aggregation2->field('color');

        $aggregation1->aggregation($aggregation2);

        $builder = (new RequestBuilder())
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

        $aggregation = new MaxAggregation();
        $aggregation->build();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $aggregation = new MaxAggregation();
        $aggregation->name('genres');
        $aggregation->build();
    }
}
