<?php

declare(strict_types=1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Span;

use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Query\Span\SpanNearQuery;
use Hypefactors\ElasticBuilder\Query\Span\SpanTermQuery;

class SpanNearQueryTest extends TestCase
{
    /** @test */
    public function it_builds_the_query()
    {
        $spanTermQuery1 = new SpanTermQuery();
        $spanTermQuery1->field('field-1');
        $spanTermQuery1->value('value-1');

        $spanTermQuery2 = new SpanTermQuery();
        $spanTermQuery2->field('field-2');
        $spanTermQuery2->value('value-2');

        $query = new SpanNearQuery();
        $query->addQuery($spanTermQuery1);
        $query->addQuery($spanTermQuery2);

        $expectedArray = [
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

        $expectedJson = <<<JSON
{
    "span_near": {
        "clauses": [
            {
                "span_term": {
                    "field-1": "value-1"
                }
            },
            {
                "span_term": {
                    "field-2": "value-2"
                }
            }
        ]
    }
}
JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_with_the_slop_parameter()
    {
        $spanTermQuery1 = new SpanTermQuery();
        $spanTermQuery1->field('field-1');
        $spanTermQuery1->value('value-1');

        $spanTermQuery2 = new SpanTermQuery();
        $spanTermQuery2->field('field-2');
        $spanTermQuery2->value('value-2');

        $query = new SpanNearQuery();
        $query->addQuery($spanTermQuery1);
        $query->addQuery($spanTermQuery2);
        $query->slop(5);

        $expectedArray = [
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

        $expectedJson = <<<JSON
{
    "span_near": {
        "slop": 5,
        "clauses": [
            {
                "span_term": {
                    "field-1": "value-1"
                }
            },
            {
                "span_term": {
                    "field-2": "value-2"
                }
            }
        ]
    }
}
JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_with_the_in_order_parameter()
    {
        $spanTermQuery1 = new SpanTermQuery();
        $spanTermQuery1->field('field-1');
        $spanTermQuery1->value('value-1');

        $spanTermQuery2 = new SpanTermQuery();
        $spanTermQuery2->field('field-2');
        $spanTermQuery2->value('value-2');

        $query = new SpanNearQuery();
        $query->addQuery($spanTermQuery1);
        $query->addQuery($spanTermQuery2);
        $query->inOrder(true);

        $expectedArray = [
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

        $expectedJson = <<<JSON
{
    "span_near": {
        "in_order": true,
        "clauses": [
            {
                "span_term": {
                    "field-1": "value-1"
                }
            },
            {
                "span_term": {
                    "field-2": "value-2"
                }
            }
        ]
    }
}
JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }
}
