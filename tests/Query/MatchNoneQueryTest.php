<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query;

use Hypefactors\ElasticBuilder\Query\MatchNoneQuery;
use Hypefactors\ElasticBuilder\QueryBuilderInterface;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;

class MatchNoneQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilder->query(function (QueryBuilderInterface $queryBuilder) {
            $matchNoneQuery = new MatchNoneQuery();

            $queryBuilder->matchNone($matchNoneQuery);

            $expected = [
                'match_none' => [],
            ];

            $this->assertFalse($matchNoneQuery->isEmpty());
            $this->assertSame($expected, $matchNoneQuery->build());
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
            $matchNoneQuery = new MatchNoneQuery();
            $matchNoneQuery->boost(1.5);

            $queryBuilder->matchNone($matchNoneQuery);

            $expected = [
                'match_none' => [
                    'boost' => 1.5,
                ],
            ];

            $this->assertFalse($matchNoneQuery->isEmpty());
            $this->assertSame($expected, $matchNoneQuery->build());
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
            $matchNoneQuery = new MatchNoneQuery();
            $matchNoneQuery->name('my-query-name');

            $queryBuilder->matchNone($matchNoneQuery);

            $expected = [
                'match_none' => [
                    '_name' => 'my-query-name',
                ],
            ];

            $this->assertFalse($matchNoneQuery->isEmpty());
            $this->assertSame($expected, $matchNoneQuery->build());
        });

        $response = $this->client->search($requestBuilder->build());

        $this->assertArrayHasKey('took', $response);
    }
}
