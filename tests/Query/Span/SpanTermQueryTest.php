<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Span;

use Hypefactors\ElasticBuilder\Query\Span\SpanTermQuery;
use Hypefactors\ElasticBuilder\QueryBuilder;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;
use InvalidArgumentException;

class SpanTermQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $spanTermQuery = new SpanTermQuery();
        $spanTermQuery->field('user');
        $spanTermQuery->value('kimchy');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->spanTerm($spanTermQuery);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'span_term' => [
                'user' => 'kimchy',
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($spanTermQuery->isEmpty());
        $this->assertSame($expected, $spanTermQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_boost_factor_parameter()
    {
        $spanTermQuery = new SpanTermQuery();
        $spanTermQuery->field('user');
        $spanTermQuery->value('kimchy');
        $spanTermQuery->boost(1.0);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->spanTerm($spanTermQuery);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'span_term' => [
                'user' => [
                    'value' => 'kimchy',
                    'boost' => 1.0,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($spanTermQuery->isEmpty());
        $this->assertSame($expected, $spanTermQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_name_parameter()
    {
        $spanTermQuery = new SpanTermQuery();
        $spanTermQuery->field('user');
        $spanTermQuery->value('kimchy');
        $spanTermQuery->name('my-query-name');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->spanTerm($spanTermQuery);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'span_term' => [
                'user' => [
                    'value' => 'kimchy',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($spanTermQuery->isEmpty());
        $this->assertSame($expected, $spanTermQuery->build());
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $spanTermQuery = new SpanTermQuery();
        $spanTermQuery->build();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_parameter_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "value" is required!');

        $spanTermQuery = new SpanTermQuery();
        $spanTermQuery->field('user');

        $spanTermQuery->build();
    }
}
