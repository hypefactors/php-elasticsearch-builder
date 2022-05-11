<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\ExistsQuery;
use Hypefactors\ElasticBuilder\QueryBuilder;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;
use InvalidArgumentException;

class ExistsQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $existsQuery = new ExistsQuery();
        $existsQuery->field('name');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($existsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($existsQuery) {
                $query->exists($existsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'exists' => [
                'field' => 'name',
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($existsQuery->isEmpty());
        $this->assertSame($expected, $existsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_boost_factor_parameter()
    {
        $existsQuery = new ExistsQuery();
        $existsQuery->field('name');
        $existsQuery->boost(1.5);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($existsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($existsQuery) {
                $query->exists($existsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'exists' => [
                'field' => 'name',
                'boost' => 1.5,
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($existsQuery->isEmpty());
        $this->assertSame($expected, $existsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_name_parameter()
    {
        $existsQuery = new ExistsQuery();
        $existsQuery->field('name');
        $existsQuery->name('my-query-name');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($existsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($existsQuery) {
                $query->exists($existsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'exists' => [
                'field' => 'name',
                '_name' => 'my-query-name',
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($existsQuery->isEmpty());
        $this->assertSame($expected, $existsQuery->build());
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $existsQuery = new ExistsQuery();

        $existsQuery->build();
    }
}
