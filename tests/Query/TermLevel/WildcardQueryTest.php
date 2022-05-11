<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\WildcardQuery;
use Hypefactors\ElasticBuilder\QueryBuilder;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;
use InvalidArgumentException;

class WildcardQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $wildcardQuery = new WildcardQuery();
        $wildcardQuery->field('user');
        $wildcardQuery->value('john');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($wildcardQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($wildcardQuery) {
                $query->wildcard($wildcardQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'wildcard' => [
                'user' => 'john',
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($wildcardQuery->isEmpty());
        $this->assertSame($expected, $wildcardQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_boost_factor_parameter()
    {
        $wildcardQuery = new WildcardQuery();
        $wildcardQuery->field('user');
        $wildcardQuery->value('john');
        $wildcardQuery->boost(1.5);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($wildcardQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($wildcardQuery) {
                $query->wildcard($wildcardQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'wildcard' => [
                'user' => [
                    'value' => 'john',
                    'boost' => 1.5,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($wildcardQuery->isEmpty());
        $this->assertSame($expected, $wildcardQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_name_parameter()
    {
        $wildcardQuery = new WildcardQuery();
        $wildcardQuery->field('user');
        $wildcardQuery->value('john');
        $wildcardQuery->name('my-query-name');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($wildcardQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($wildcardQuery) {
                $query->wildcard($wildcardQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'wildcard' => [
                'user' => [
                    'value' => 'john',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($wildcardQuery->isEmpty());
        $this->assertSame($expected, $wildcardQuery->build());
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $wildcardQuery = new WildcardQuery();
        $wildcardQuery->build();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_value_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "value" is required!');

        $wildcardQuery = new WildcardQuery();
        $wildcardQuery->field('user');

        $wildcardQuery->build();
    }
}
