<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalQueryRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\AllOfRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule\NotContainingRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\MatchRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQuery;
use PHPUnit\Framework\TestCase;

class AllOfRuleTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_have_intervals_on_the_query_using_a_callable()
    {
        $query = new AllOfRule();
        $query->intervals(function (IntervalsQuery $query) {
            $query->match(function (MatchRule $query) {
                $query->query('foo');
            });
        });

        $expectedArray = [
            'all_of' => [
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
                "all_of": {
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

        $query = new AllOfRule();
        $query->intervals($intervalsQuery);

        $expectedArray = [
            'all_of' => [
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
                "all_of": {
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
    public function it_can_have_max_gaps_on_the_query()
    {
        $query = new AllOfRule();
        $query->maxGaps(1);

        $expectedArray = [
            'all_of' => [
                'max_gaps' => 1,
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "all_of": {
                    "max_gaps": 1
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_have_ordered_enabled_on_the_query()
    {
        $query = new AllOfRule();
        $query->ordered(true);

        $expectedArray = [
            'all_of' => [
                'ordered' => true,
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "all_of": {
                    "ordered": true
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_have_ordered_disabled_on_the_query()
    {
        $query = new AllOfRule();
        $query->ordered(false);

        $expectedArray = [
            'all_of' => [
                'ordered' => false,
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "all_of": {
                    "ordered": false
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
        $query = new AllOfRule();
        $query->filter(function (FilterRule $query) {
            $query->notContaining(function (NotContainingRule $query) {
                $query->match(function (MatchRule $query) {
                    $query->query('my-query');
                });
            });
        });

        $expectedArray = [
            'all_of' => [
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
                "all_of": {
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

        $query = new AllOfRule();
        $query->filter($filterRule);

        $expectedArray = [
            'all_of' => [
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
                "all_of": {
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
