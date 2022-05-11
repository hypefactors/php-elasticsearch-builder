<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Span;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQueryInterface;
use Hypefactors\ElasticBuilder\Query\Span\SpanNearQuery;
use Hypefactors\ElasticBuilder\Query\Span\SpanTermQuery;
use Hypefactors\ElasticBuilder\QueryBuilder;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;

class SpanNearQueryTest extends TestCase
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

        $spanNearQuery = new SpanNearQuery();
        $spanNearQuery->spanTerm($spanTermQuery1);
        $spanNearQuery->spanTerm($spanTermQuery2);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->spanNear($spanNearQuery);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'span_near' => [
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
        $this->assertFalse($spanNearQuery->isEmpty());
        $this->assertSame($expected, $spanNearQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_slop_parameter()
    {
        $spanTermQuery1 = new SpanTermQuery();
        $spanTermQuery1->field('field-1');
        $spanTermQuery1->value('value-1');

        $spanTermQuery2 = new SpanTermQuery();
        $spanTermQuery2->field('field-2');
        $spanTermQuery2->value('value-2');

        $spanNearQuery = new SpanNearQuery();
        $spanNearQuery->spanTerm($spanTermQuery1);
        $spanNearQuery->spanTerm($spanTermQuery2);
        $spanNearQuery->slop(5);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->spanNear($spanNearQuery);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'span_near' => [
                'slop'    => 5,
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
        $this->assertFalse($spanNearQuery->isEmpty());
        $this->assertSame($expected, $spanNearQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_in_order_parameter()
    {
        $spanTermQuery1 = new SpanTermQuery();
        $spanTermQuery1->field('field-1');
        $spanTermQuery1->value('value-1');

        $spanTermQuery2 = new SpanTermQuery();
        $spanTermQuery2->field('field-2');
        $spanTermQuery2->value('value-2');

        $spanNearQuery = new SpanNearQuery();
        $spanNearQuery->spanTerm($spanTermQuery1);
        $spanNearQuery->spanTerm($spanTermQuery2);
        $spanNearQuery->inOrder(true);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->spanNear($spanNearQuery);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'span_near' => [
                'in_order' => true,
                'clauses'  => [
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
        $this->assertFalse($spanNearQuery->isEmpty());
        $this->assertSame($expected, $spanNearQuery->build());
    }
}
