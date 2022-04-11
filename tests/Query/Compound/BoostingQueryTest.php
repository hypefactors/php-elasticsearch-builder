<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Compound;

use Hypefactors\ElasticBuilder\Query\Compound\BoostingQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;
use PHPUnit\Framework\TestCase;

class BoostingQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query_with_the_positive_parameter()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $query = new BoostingQuery();
        $query->positive($termQuery);

        $expectedArray = [
            'boosting' => [
                'positive' => [
                    'term' => [
                        'user' => 'john',
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "boosting": {
                    "positive": {
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
    public function it_builds_the_query_with_the_negative_parameter()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $query = new BoostingQuery();
        $query->negative($termQuery);

        $expectedArray = [
            'boosting' => [
                'negative' => [
                    'term' => [
                        'user' => 'john',
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "boosting": {
                    "negative": {
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
    public function it_builds_the_query_with_the_positive_and_negative_parameters()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $query = new BoostingQuery();
        $query->positive($termQuery);
        $query->negative($termQuery);

        $expectedArray = [
            'boosting' => [
                'positive' => [
                    'term' => [
                        'user' => 'john',
                    ],
                ],
                'negative' => [
                    'term' => [
                        'user' => 'john',
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "boosting": {
                    "positive": {
                        "term": {
                            "user": "john"
                        }
                    },
                    "negative": {
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
    public function it_builds_the_query_with_the_negative_boost_parameter()
    {
        $query = new BoostingQuery();
        $query->negativeBoost(2);

        $expectedArray = [
            'boosting' => [
                'negative_boost' => 2,
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "boosting": {
                    "negative_boost": 2
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }
}
