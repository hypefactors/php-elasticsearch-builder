<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Span;

use Hypefactors\ElasticBuilder\Query\Span\SpanOrQuery;
use Hypefactors\ElasticBuilder\Query\Span\SpanTermQuery;
use Hypefactors\ElasticBuilder\QueryBuilder;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;

class SpanOrQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $spanTermQuery1 = new SpanTermQuery();
        $spanTermQuery1->field('field-1');
        $spanTermQuery1->value('value-1');

        $spanTermQuery2 = new SpanTermQuery();
        $spanTermQuery2->field('field-2');
        $spanTermQuery2->value('value-2');

        $spanOrQuery = new SpanOrQuery();
        $spanOrQuery->spanTerm($spanTermQuery1);
        $spanOrQuery->spanTerm($spanTermQuery2);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->spanOr($spanOrQuery);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'span_or' => [
                'clauses' => [
                    [
                        'span_term' => [
                            'field-1' => 'value-1',
                        ],
                    ],
                    [
                        'span_term' => [
                            'field-2' => 'value-2',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($spanOrQuery->isEmpty());
        $this->assertSame($expected, $spanOrQuery->build());
    }
}
