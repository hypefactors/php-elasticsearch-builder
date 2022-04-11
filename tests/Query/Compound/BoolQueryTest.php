<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Compound;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\ExistsQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;
use PHPUnit\Framework\TestCase;

class BoolQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_applies_the_filter_clause_to_the_query()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $query = new BoolQuery();
        $query->filter($termQuery);

        $expectedArray = [
            'bool' => [
                'filter' => [
                    'term' => [
                        'user' => 'john',
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "bool": {
                    "filter": {
                        "term": {
                            "user": "john"
                        }
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_applies_the_must_clause_to_the_query()
    {
        $existsQuery = new ExistsQuery();
        $existsQuery->field('user');

        $query = new BoolQuery();
        $query->must($existsQuery);

        $expectedArray = [
            'bool' => [
                'must' => [
                    'exists' => [
                        'field' => 'user',
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "bool": {
                    "must": {
                        "exists": {
                            "field": "user"
                        }
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_applies_the_must_not_clause_to_the_query()
    {
        $existsQuery = new ExistsQuery();
        $existsQuery->field('user');

        $query = new BoolQuery();
        $query->mustNot($existsQuery);

        $expectedArray = [
            'bool' => [
                'must_not' => [
                    'exists' => [
                        'field' => 'user',
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "bool": {
                    "must_not": {
                        "exists": {
                            "field": "user"
                        }
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_applies_the_should_clause_to_the_query()
    {
        $existsQuery = new ExistsQuery();
        $existsQuery->field('user');

        $query = new BoolQuery();
        $query->should($existsQuery);

        $expectedArray = [
            'bool' => [
                'should' => [
                    'exists' => [
                        'field' => 'user',
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "bool": {
                    "should": {
                        "exists": {
                            "field": "user"
                        }
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_combine_multiple_clauses_and_applies_them_to_the_query()
    {
        $existsQuery1 = new ExistsQuery();
        $existsQuery1->field('user');

        $existsQuery2 = new ExistsQuery();
        $existsQuery2->field('other_field');

        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $query = new BoolQuery();
        $query->must($termQuery);
        $query->must($existsQuery1);
        $query->mustNot($existsQuery2);

        $expectedArray = [
            'bool' => [
                'must' => [
                    [
                        'term' => [
                            'user' => 'john',
                        ],
                    ],
                    [
                        'exists' => [
                            'field' => 'user',
                        ],
                    ],
                ],
                'must_not' => [
                    'exists' => [
                        'field' => 'other_field',
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "bool": {
                    "must": [
                        {
                            "term": {
                                "user": "john"
                            }
                        },
                        {
                            "exists": {
                                "field": "user"
                            }
                        }
                    ],
                    "must_not": {
                        "exists": {
                            "field": "other_field"
                        }
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }
}
