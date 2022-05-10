<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\IdsQuery;
use Hypefactors\ElasticBuilder\QueryBuilder;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;
use InvalidArgumentException;

class IdsQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query_with_values_parameter()
    {
        $idsQuery = new IdsQuery();
        $idsQuery->values(['1', '4', '10']);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($idsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($idsQuery) {
                $query->ids($idsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'ids' => [
                'values' => ['1', '4', '10'],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($idsQuery->isEmpty());
        $this->assertSame($expected, $idsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_boost_factor_parameter()
    {
        $idsQuery = new IdsQuery();
        $idsQuery->values(['1', '4', '10']);
        $idsQuery->boost(1.5);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($idsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($idsQuery) {
                $query->ids($idsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'ids' => [
                'values' => ['1', '4', '10'],
                'boost'  => 1.5,
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($idsQuery->isEmpty());
        $this->assertSame($expected, $idsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_name_parameter()
    {
        $idsQuery = new IdsQuery();
        $idsQuery->values(['1', '4', '10']);
        $idsQuery->name('my-query-name');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($idsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($idsQuery) {
                $query->ids($idsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'ids' => [
                'values' => ['1', '4', '10'],
                '_name'  => 'my-query-name',
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($idsQuery->isEmpty());
        $this->assertSame($expected, $idsQuery->build());
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_values_are_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "values" are required!');

        $idsQuery = new IdsQuery();
        $idsQuery->build();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_are_set_but_they_are_empty_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "values" cannot be empty!');

        $idsQuery = new IdsQuery();
        $idsQuery->values([]);

        $idsQuery->build();
    }
}
