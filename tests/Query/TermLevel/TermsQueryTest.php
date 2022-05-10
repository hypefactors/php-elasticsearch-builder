<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermsQuery;
use Hypefactors\ElasticBuilder\QueryBuilder;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;
use InvalidArgumentException;

class TermsQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query_for_a_single_value()
    {
        $termsQuery = new TermsQuery();
        $termsQuery->field('user');
        $termsQuery->value('john');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($termsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($termsQuery) {
                $query->terms($termsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'terms' => [
                'user' => ['john'],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($termsQuery->isEmpty());
        $this->assertSame($expected, $termsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_a_single_value_with_the_boost_factor_parameter()
    {
        $termsQuery = new TermsQuery();
        $termsQuery->field('user');
        $termsQuery->value('john');
        $termsQuery->boost(1.5);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($termsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($termsQuery) {
                $query->terms($termsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'terms' => [
                'user'  => ['john'],
                'boost' => 1.5,
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($termsQuery->isEmpty());
        $this->assertSame($expected, $termsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_a_single_value_with_name_parameter()
    {
        $termsQuery = new TermsQuery();
        $termsQuery->field('user');
        $termsQuery->value('john');
        $termsQuery->name('my-query-name');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($termsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($termsQuery) {
                $query->terms($termsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'terms' => [
                'user'  => ['john'],
                '_name' => 'my-query-name',
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($termsQuery->isEmpty());
        $this->assertSame($expected, $termsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_multiple_values()
    {
        $termsQuery = new TermsQuery();
        $termsQuery->field('user');
        $termsQuery->values(['john', 'jane']);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($termsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($termsQuery) {
                $query->terms($termsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'terms' => [
                'user' => ['john', 'jane'],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($termsQuery->isEmpty());
        $this->assertSame($expected, $termsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_multiple_values_with_the_boost_factor_parameter()
    {
        $termsQuery = new TermsQuery();
        $termsQuery->field('user');
        $termsQuery->values(['john', 'jane']);
        $termsQuery->boost(1.5);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($termsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($termsQuery) {
                $query->terms($termsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'terms' => [
                'user'  => ['john', 'jane'],
                'boost' => 1.5,
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($termsQuery->isEmpty());
        $this->assertSame($expected, $termsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_multiple_values_with_the_name_parameter()
    {
        $termsQuery = new TermsQuery();
        $termsQuery->field('user');
        $termsQuery->values(['john', 'jane']);
        $termsQuery->name('my-query-name');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($termsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($termsQuery) {
                $query->terms($termsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'terms' => [
                'user'  => ['john', 'jane'],
                '_name' => 'my-query-name',
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($termsQuery->isEmpty());
        $this->assertSame($expected, $termsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_multiple_values_and_removes_duplicated_values()
    {
        $termsQuery = new TermsQuery();
        $termsQuery->field('user');
        $termsQuery->values(['john', 'jane']);
        $termsQuery->value('john');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($termsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($termsQuery) {
                $query->terms($termsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'terms' => [
                'user' => ['john', 'jane'],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($termsQuery->isEmpty());
        $this->assertSame($expected, $termsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_the_given_terms_lookup()
    {
        $termsQuery = new TermsQuery();
        $termsQuery->field('user');
        $termsQuery->termsLookup([
            'id'    => 'ci-id',
            'index' => 'ci-index',
            'path'  => 'ci-path',
        ]);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($termsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($termsQuery) {
                $query->terms($termsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'terms' => [
                'user' => [
                    'id'    => 'ci-id',
                    'index' => 'ci-index',
                    'path'  => 'ci-path',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($termsQuery->isEmpty());
        $this->assertSame($expected, $termsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_an_id_index_path_term_lookup()
    {
        $termsQuery = new TermsQuery();
        $termsQuery->field('user');
        $termsQuery->id('ci-id');
        $termsQuery->index('ci-index');
        $termsQuery->path('ci-path');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($termsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($termsQuery) {
                $query->terms($termsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'terms' => [
                'user' => [
                    'id'    => 'ci-id',
                    'index' => 'ci-index',
                    'path'  => 'ci-path',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($termsQuery->isEmpty());
        $this->assertSame($expected, $termsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_a_routing_term_lookup()
    {
        $termsQuery = new TermsQuery();
        $termsQuery->field('user');
        $termsQuery->id('ci-id');
        $termsQuery->index('ci-index');
        $termsQuery->path('ci-path');
        $termsQuery->routing('ci-routing');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($termsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($termsQuery) {
                $query->terms($termsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'terms' => [
                'user' => [
                    'id'    => 'ci-id',
                    'index' => 'ci-index',
                    'path'  => 'ci-path',
                    'routing' => 'ci-routing',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($termsQuery->isEmpty());
        $this->assertSame($expected, $termsQuery->build());
    }

    /**
     * @test
     */
    public function it_ensures_the_values_are_unique_and_without_weird_indexes()
    {
        $termsQuery = new TermsQuery();
        $termsQuery->field('user');
        $termsQuery->values([
            0 => 'value1',
            1 => 'value2',
            2 => 'value2',
            3 => 'value3',
        ]);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($termsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($termsQuery) {
                $query->terms($termsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'terms' => [
                'user' => ['value1', 'value2', 'value3'],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($termsQuery->isEmpty());
        $this->assertSame($expected, $termsQuery->build());
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $termsQuery = new TermsQuery();
        $termsQuery->build();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_values_are_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "values" are required!');

        $termsQuery = new TermsQuery();
        $termsQuery->field('user');

        $termsQuery->build();
    }
}
