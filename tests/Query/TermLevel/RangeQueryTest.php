<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\RangeQuery;
use Hypefactors\ElasticBuilder\QueryBuilder;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;
use InvalidArgumentException;

class RangeQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query_with_the_boost_factor_parameter()
    {
        $rangeQuery = new RangeQuery();
        $rangeQuery->field('user');
        $rangeQuery->boost(1.5);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($rangeQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($rangeQuery) {
                $query->range($rangeQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'range' => [
                'user' => [
                    'boost' => 1.5,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($rangeQuery->isEmpty());
        $this->assertSame($expected, $rangeQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_name_parameter()
    {
        $rangeQuery = new RangeQuery();
        $rangeQuery->field('user');
        $rangeQuery->name('my-query-name');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($rangeQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($rangeQuery) {
                $query->range($rangeQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'range' => [
                'user' => [
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($rangeQuery->isEmpty());
        $this->assertSame($expected, $rangeQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_less_than_parameter()
    {
        $rangeQuery = new RangeQuery();
        $rangeQuery->field('user');
        $rangeQuery->lessThan(10);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($rangeQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($rangeQuery) {
                $query->range($rangeQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'range' => [
                'user' => [
                    'lt' => 10,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($rangeQuery->isEmpty());
        $this->assertSame($expected, $rangeQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_less_than_or_equal_parameter()
    {
        $rangeQuery = new RangeQuery();
        $rangeQuery->field('user');
        $rangeQuery->lessThanEquals(10);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($rangeQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($rangeQuery) {
                $query->range($rangeQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'range' => [
                'user' => [
                    'lte' => 10,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($rangeQuery->isEmpty());
        $this->assertSame($expected, $rangeQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_greater_than_parameter()
    {
        $rangeQuery = new RangeQuery();
        $rangeQuery->field('user');
        $rangeQuery->greaterThan(12);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($rangeQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($rangeQuery) {
                $query->range($rangeQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'range' => [
                'user' => [
                    'gt' => 12,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($rangeQuery->isEmpty());
        $this->assertSame($expected, $rangeQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_greater_than_or_equal_parameter()
    {
        $rangeQuery = new RangeQuery();
        $rangeQuery->field('user');
        $rangeQuery->greaterThanEquals(12);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($rangeQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($rangeQuery) {
                $query->range($rangeQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'range' => [
                'user' => [
                    'gte' => 12,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($rangeQuery->isEmpty());
        $this->assertSame($expected, $rangeQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_format_parameter()
    {
        $rangeQuery = new RangeQuery();
        $rangeQuery->field('user');
        $rangeQuery->format('yyyy-MM-dd');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($rangeQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($rangeQuery) {
                $query->range($rangeQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'range' => [
                'user' => [
                    'format' => 'yyyy-MM-dd',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($rangeQuery->isEmpty());
        $this->assertSame($expected, $rangeQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_relation_parameter()
    {
        $rangeQuery = new RangeQuery();
        $rangeQuery->field('user');
        $rangeQuery->relation('INTERSECTS');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($rangeQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($rangeQuery) {
                $query->range($rangeQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'range' => [
                'user' => [
                    'relation' => 'INTERSECTS',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($rangeQuery->isEmpty());
        $this->assertSame($expected, $rangeQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_timezone_parameter()
    {
        $rangeQuery = new RangeQuery();
        $rangeQuery->field('user');
        $rangeQuery->timezone('+01:00');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($rangeQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($rangeQuery) {
                $query->range($rangeQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'range' => [
                'user' => [
                    'time_zone' => '+01:00',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($rangeQuery->isEmpty());
        $this->assertSame($expected, $rangeQuery->build());
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_when_setting_an_invalid_relation()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [foo] relation is invalid!');

        $rangeQuery = new RangeQuery();
        $rangeQuery->field('user');
        $rangeQuery->relation('foo');
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $rangeQuery = new RangeQuery();
        $rangeQuery->build();
    }
}
