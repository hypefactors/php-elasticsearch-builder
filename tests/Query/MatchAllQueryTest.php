<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query;

use Hypefactors\ElasticBuilder\Query\MatchAllQuery;
use Hypefactors\ElasticBuilder\QueryBuilderInterface;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;

class MatchAllQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilder->query(function (QueryBuilderInterface $queryBuilder) {
            $matchAllQuery = new MatchAllQuery();

            $queryBuilder->matchAll($matchAllQuery);

            $expected = [
                'match_all' => [],
            ];

            $this->assertFalse($matchAllQuery->isEmpty());
            $this->assertSame($expected, $matchAllQuery->build());
        });

        $response = $this->client->search($requestBuilder->build());

        $this->assertArrayHasKey('took', $response);
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_boost_factor_parameter()
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilder->query(function (QueryBuilderInterface $queryBuilder) {
            $matchAllQuery = new MatchAllQuery();
            $matchAllQuery->boost(1.5);

            $queryBuilder->matchAll($matchAllQuery);

            $expected = [
                'match_all' => [
                    'boost' => 1.5,
                ],
            ];

            $this->assertFalse($matchAllQuery->isEmpty());
            $this->assertSame($expected, $matchAllQuery->build());
        });

        $response = $this->client->search($requestBuilder->build());

        $this->assertArrayHasKey('took', $response);
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_name_parameter()
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilder->query(function (QueryBuilderInterface $queryBuilder) {
            $matchAllQuery = new MatchAllQuery();
            $matchAllQuery->name('my-query-name');

            $queryBuilder->matchAll($matchAllQuery);

            $expected = [
                'match_all' => [
                    '_name' => 'my-query-name',
                ],
            ];

            $this->assertFalse($matchAllQuery->isEmpty());
            $this->assertSame($expected, $matchAllQuery->build());
        });

        $response = $this->client->search($requestBuilder->build());

        $this->assertArrayHasKey('took', $response);
    }
}
