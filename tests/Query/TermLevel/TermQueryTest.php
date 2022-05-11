<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;
use Hypefactors\ElasticBuilder\QueryBuilder;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;
use InvalidArgumentException;

class TermQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($termQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($termQuery) {
                $query->term($termQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'term' => [
                'user' => 'john',
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($termQuery->isEmpty());
        $this->assertSame($expected, $termQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_boost_factor_parameter()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');
        $termQuery->boost(1.5);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($termQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($termQuery) {
                $query->term($termQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'term' => [
                'user' => [
                    'value' => 'john',
                    'boost' => 1.5,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($termQuery->isEmpty());
        $this->assertSame($expected, $termQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_name_parameter()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');
        $termQuery->name('my-query-name');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($termQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($termQuery) {
                $query->term($termQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'term' => [
                'user' => [
                    'value' => 'john',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($termQuery->isEmpty());
        $this->assertSame($expected, $termQuery->build());
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $termQuery = new TermQuery();
        $termQuery->build();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_value_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "value" is required!');

        $termQuery = new TermQuery();
        $termQuery->field('user');

        $termQuery->build();
    }
}
