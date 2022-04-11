<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Span;

use Hypefactors\ElasticBuilder\Query\Span\SpanOrQuery;
use Hypefactors\ElasticBuilder\Query\Span\SpanTermQuery;
use PHPUnit\Framework\TestCase;

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

        $query = new SpanOrQuery();
        $query->addQuery($spanTermQuery1);
        $query->addQuery($spanTermQuery2);

        $expectedArray = [
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

        $expectedJson = <<<'JSON'
            {
                "span_or": {
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
