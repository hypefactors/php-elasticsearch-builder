<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\PrefixQuery;
use Hypefactors\ElasticBuilder\QueryBuilder;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;
use InvalidArgumentException;

class PrefixQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $prefixQuery = new PrefixQuery();
        $prefixQuery->field('user');
        $prefixQuery->value('ki');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($prefixQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($prefixQuery) {
                $query->prefix($prefixQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'prefix' => [
                'user' => 'ki',
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($prefixQuery->isEmpty());
        $this->assertSame($expected, $prefixQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_boost_factor_parameter()
    {
        $prefixQuery = new PrefixQuery();
        $prefixQuery->field('user');
        $prefixQuery->value('ki');
        $prefixQuery->boost(1.5);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($prefixQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($prefixQuery) {
                $query->prefix($prefixQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'prefix' => [
                'user' => [
                    'value' => 'ki',
                    'boost' => 1.5,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($prefixQuery->isEmpty());
        $this->assertSame($expected, $prefixQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_name_parameter()
    {
        $prefixQuery = new PrefixQuery();
        $prefixQuery->field('user');
        $prefixQuery->value('ki');
        $prefixQuery->name('my-query-name');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($prefixQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($prefixQuery) {
                $query->prefix($prefixQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'prefix' => [
                'user' => [
                    'value' => 'ki',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($prefixQuery->isEmpty());
        $this->assertSame($expected, $prefixQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_rewrite_parameter()
    {
        $prefixQuery = new PrefixQuery();
        $prefixQuery->field('user');
        $prefixQuery->value('ki');
        $prefixQuery->rewrite('rewrite');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($prefixQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($prefixQuery) {
                $query->prefix($prefixQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'prefix' => [
                'user' => [
                    'value'   => 'ki',
                    'rewrite' => 'rewrite',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($prefixQuery->isEmpty());
        $this->assertSame($expected, $prefixQuery->build());
    }

    /**
     * @test
     */
    public function exception_will_be_thrown_if_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $prefixQuery = new PrefixQuery();
        $prefixQuery->build();
    }

    /**
     * @test
     */
    public function exception_will_be_thrown_if_value_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "value" is required!');

        $prefixQuery = new PrefixQuery();
        $prefixQuery->field('user');

        $prefixQuery->build();
    }
}
