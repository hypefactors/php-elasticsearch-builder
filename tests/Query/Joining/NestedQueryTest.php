<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Joining;

use Hypefactors\ElasticBuilder\Core\InnerHits;
use Hypefactors\ElasticBuilder\Core\InnerHitsInterface;
use Hypefactors\ElasticBuilder\Query\Joining\NestedQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermsQuery;
use Hypefactors\ElasticBuilder\QueryBuilder;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;
use InvalidArgumentException;

class NestedQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $termQuery = new TermsQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $nestedQuery = new NestedQuery();
        $nestedQuery->path('some-path');
        $nestedQuery->query($termQuery);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->nested($nestedQuery);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'nested' => [
                'path'  => 'some-path',
                'query' => [
                    'terms' => [
                        'user' => ['john'],
                    ],
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($nestedQuery->isEmpty());
        $this->assertSame($expected, $nestedQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_score_mode_parameter()
    {
        $termQuery = new TermsQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $nestedQuery = new NestedQuery();
        $nestedQuery->path('some-path');
        $nestedQuery->query($termQuery);
        $nestedQuery->scoreMode('avg');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->nested($nestedQuery);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'nested' => [
                'path'  => 'some-path',
                'query' => [
                    'terms' => [
                        'user' => ['john'],
                    ],
                ],
                'score_mode' => 'avg',
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($nestedQuery->isEmpty());
        $this->assertSame($expected, $nestedQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_ignore_unmapped_parameter()
    {
        $termQuery = new TermsQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $nestedQuery = new NestedQuery();
        $nestedQuery->path('some-path');
        $nestedQuery->query($termQuery);
        $nestedQuery->ignoreUnmapped(true);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->nested($nestedQuery);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'nested' => [
                'path'  => 'some-path',
                'query' => [
                    'terms' => [
                        'user' => ['john'],
                    ],
                ],
                'ignore_unmapped' => true,
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($nestedQuery->isEmpty());
        $this->assertSame($expected, $nestedQuery->build());
    }

    /**
     * @test
     */
    public function the_inner_hits_can_be_applied_using_a_class_instance()
    {
        $termQuery = new TermsQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $innerHits = new InnerHits();
        $innerHits->name('named-query');

        $nestedQuery = new NestedQuery();
        $nestedQuery->path('some-path');
        $nestedQuery->query($termQuery);
        $nestedQuery->innerHits($innerHits);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->nested($nestedQuery);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'nested' => [
                'path'  => 'some-path',
                'query' => [
                    'terms' => [
                        'user' => ['john'],
                    ],
                ],
                'inner_hits' => [
                    'name' => 'named-query',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($nestedQuery->isEmpty());
        $this->assertSame($expected, $nestedQuery->build());
    }

    /**
     * @test
     */
    public function the_inner_hits_can_be_applied_using_a_closure()
    {
        $termQuery = new TermsQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $nestedQuery = new NestedQuery();
        $nestedQuery->path('some-path');
        $nestedQuery->query($termQuery);
        $nestedQuery->innerHits(function (InnerHitsInterface $query) {
            $query->name('named-query');
        });

        $queryBuilder = new QueryBuilder();
        $queryBuilder->nested($nestedQuery);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'nested' => [
                'path'  => 'some-path',
                'query' => [
                    'terms' => [
                        'user' => ['john'],
                    ],
                ],
                'inner_hits' => [
                    'name' => 'named-query',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($nestedQuery->isEmpty());
        $this->assertSame($expected, $nestedQuery->build());
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_when_passing_an_invalid_score_mode()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [foo] score mode is invalid.');

        $termQuery = new TermsQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $nestedQuery = new NestedQuery();
        $nestedQuery->path('some-path');
        $nestedQuery->query($termQuery);
        $nestedQuery->scoreMode('foo');
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_path_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "path" is required!');

        $nestedQuery = new NestedQuery();
        $nestedQuery->build();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_query_are_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "query" is required!');

        $nestedQuery = new NestedQuery();
        $nestedQuery->path('some-path');

        $nestedQuery->build();
    }
}
