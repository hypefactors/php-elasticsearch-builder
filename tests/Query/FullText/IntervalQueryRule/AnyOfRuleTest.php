<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalQueryRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\AnyOfRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule\NotContainingRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\MatchRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQuery;
use PHPUnit\Framework\TestCase;

class AnyOfRuleTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_have_intervals_on_the_query_using_a_callable()
    {
        $query = new AnyOfRule();
        $query->intervals(function (IntervalsQuery $query) {
            $query->match(function (MatchRule $query) {
                $query->query('foo');
            });
        });

        $expectedArray = [
            'any_of' => [
                'intervals' => [
                    [
                        'match' => [
                            'query' => 'foo',
                        ],
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "any_of": {
                    "intervals": [
                        {
                            "match": {
                                "query": "foo"
                            }
                        }
                    ]
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_have_intervals_on_the_query_using_a_class()
    {
        $intervalsQuery = new IntervalsQuery();
        $intervalsQuery->match(function (MatchRule $query) {
            $query->query('foo');
        });

        $query = new AnyOfRule();
        $query->intervals($intervalsQuery);

        $expectedArray = [
            'any_of' => [
                'intervals' => [
                    [
                        'match' => [
                            'query' => 'foo',
                        ],
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "any_of": {
                    "intervals": [
                        {
                            "match": {
                                "query": "foo"
                            }
                        }
                    ]
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_have_filter_on_the_query_using_a_callable()
    {
        $query = new AnyOfRule();
        $query->filter(function (FilterRule $query) {
            $query->notContaining(function (NotContainingRule $query) {
                $query->match(function (MatchRule $query) {
                    $query->query('my-query');
                });
            });
        });

        $expectedArray = [
            'any_of' => [
                'filter' => [
                    'not_containing' => [
                        'match' => [
                            'query' => 'my-query',
                        ],
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "any_of": {
                    "filter": {
                        "not_containing": {
                            "match": {
                                "query": "my-query"
                            }
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
    public function it_can_have_filter_on_the_query_using_a_class()
    {
        $filterRule = new FilterRule();
        $filterRule->notContaining(function (NotContainingRule $query) {
            $query->match(function (MatchRule $query) {
                $query->query('my-query');
            });
        });

        $query = new AnyOfRule();
        $query->filter($filterRule);

        $expectedArray = [
            'any_of' => [
                'filter' => [
                    'not_containing' => [
                        'match' => [
                            'query' => 'my-query',
                        ],
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "any_of": {
                    "filter": {
                        "not_containing": {
                            "match": {
                                "query": "my-query"
                            }
                        }
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }
}
