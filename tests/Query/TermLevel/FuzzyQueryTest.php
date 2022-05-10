<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\FuzzyQuery;
use Hypefactors\ElasticBuilder\QueryBuilder;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;
use InvalidArgumentException;

class FuzzyQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $fuzzyQuery = new FuzzyQuery();
        $fuzzyQuery->field('user');
        $fuzzyQuery->value('ki');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($fuzzyQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($fuzzyQuery) {
                $query->fuzzy($fuzzyQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fuzzy' => [
                'user' => 'ki',
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($fuzzyQuery->isEmpty());
        $this->assertSame($expected, $fuzzyQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_boost_factor_parameter()
    {
        $fuzzyQuery = new FuzzyQuery();
        $fuzzyQuery->field('user');
        $fuzzyQuery->value('ki');
        $fuzzyQuery->boost(1.0);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($fuzzyQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($fuzzyQuery) {
                $query->fuzzy($fuzzyQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fuzzy' => [
                'user' => [
                    'value' => 'ki',
                    'boost' => 1.0,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($fuzzyQuery->isEmpty());
        $this->assertSame($expected, $fuzzyQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_name_parameter()
    {
        $fuzzyQuery = new FuzzyQuery();
        $fuzzyQuery->field('user');
        $fuzzyQuery->value('ki');
        $fuzzyQuery->name('my-query-name');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($fuzzyQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($fuzzyQuery) {
                $query->fuzzy($fuzzyQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fuzzy' => [
                'user' => [
                    'value' => 'ki',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($fuzzyQuery->isEmpty());
        $this->assertSame($expected, $fuzzyQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_fuziness_parameter()
    {
        $fuzzyQuery = new FuzzyQuery();
        $fuzzyQuery->field('user');
        $fuzzyQuery->value('ki');
        $fuzzyQuery->fuzziness(2);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($fuzzyQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($fuzzyQuery) {
                $query->fuzzy($fuzzyQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fuzzy' => [
                'user' => [
                    'value'     => 'ki',
                    'fuzziness' => 2,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($fuzzyQuery->isEmpty());
        $this->assertSame($expected, $fuzzyQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_max_expansions_parameter()
    {
        $fuzzyQuery = new FuzzyQuery();
        $fuzzyQuery->field('user');
        $fuzzyQuery->value('ki');
        $fuzzyQuery->maxExpansions(100);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($fuzzyQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($fuzzyQuery) {
                $query->fuzzy($fuzzyQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fuzzy' => [
                'user' => [
                    'value'          => 'ki',
                    'max_expansions' => 100,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($fuzzyQuery->isEmpty());
        $this->assertSame($expected, $fuzzyQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_prefix_length_parameter()
    {
        $fuzzyQuery = new FuzzyQuery();
        $fuzzyQuery->field('user');
        $fuzzyQuery->value('ki');
        $fuzzyQuery->prefixLength(1);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($fuzzyQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($fuzzyQuery) {
                $query->fuzzy($fuzzyQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fuzzy' => [
                'user' => [
                    'value'         => 'ki',
                    'prefix_length' => 1,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($fuzzyQuery->isEmpty());
        $this->assertSame($expected, $fuzzyQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_transpositions_parameter_to_true()
    {
        $fuzzyQuery = new FuzzyQuery();
        $fuzzyQuery->field('user');
        $fuzzyQuery->value('ki');
        $fuzzyQuery->transpositions(true);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($fuzzyQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($fuzzyQuery) {
                $query->fuzzy($fuzzyQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fuzzy' => [
                'user' => [
                    'value'          => 'ki',
                    'transpositions' => true,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($fuzzyQuery->isEmpty());
        $this->assertSame($expected, $fuzzyQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_transpositions_parameter_to_false()
    {
        $fuzzyQuery = new FuzzyQuery();
        $fuzzyQuery->field('user');
        $fuzzyQuery->value('ki');
        $fuzzyQuery->transpositions(false);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($fuzzyQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($fuzzyQuery) {
                $query->fuzzy($fuzzyQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fuzzy' => [
                'user' => [
                    'value'          => 'ki',
                    'transpositions' => false,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($fuzzyQuery->isEmpty());
        $this->assertSame($expected, $fuzzyQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_rewrite_parameter()
    {
        $fuzzyQuery = new FuzzyQuery();
        $fuzzyQuery->field('user');
        $fuzzyQuery->value('ki');
        $fuzzyQuery->rewrite('a value');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($fuzzyQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($fuzzyQuery) {
                $query->fuzzy($fuzzyQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fuzzy' => [
                'user' => [
                    'value'   => 'ki',
                    'rewrite' => 'a value',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($fuzzyQuery->isEmpty());
        $this->assertSame($expected, $fuzzyQuery->build());
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $fuzzyQuery = new FuzzyQuery();
        $fuzzyQuery->build();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_parameter_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "value" is required!');

        $fuzzyQuery = new FuzzyQuery();
        $fuzzyQuery->field('user');

        $fuzzyQuery->build();
    }
}
