<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalQueryRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule\NotContainingRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\MatchRule;
use PHPUnit\Framework\TestCase;

class MatchRuleTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_have_query_on_the_query()
    {
        $query = new MatchRule();
        $query->query('my-query');

        $expectedArray = [
            'match' => [
                'query' => 'my-query'
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match": {
                    "query": "my-query"
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
        $query = new MatchRule();
        $query->maxGaps(1);

        $expectedArray = [
            'match' => [
                'max_gaps' => 1,
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match": {
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
        $query = new MatchRule();
        $query->ordered(true);

        $expectedArray = [
            'match' => [
                'ordered' => true,
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match": {
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
        $query = new MatchRule();
        $query->ordered(false);

        $expectedArray = [
            'match' => [
                'ordered' => false,
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match": {
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
    public function it_can_have_analyzer_on_the_query()
    {
        $query = new MatchRule();
        $query->analyzer('analyzer-string');

        $expectedArray = [
            'match' => [
                'analyzer' => 'analyzer-string'
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match": {
                    "analyzer": "analyzer-string"
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
        $query = new MatchRule();
        $query->filter(function (FilterRule $query) {
            $query->notContaining(function (NotContainingRule $query) {
                $query->match(function (MatchRule $query) {
                    $query->query('my-query');
                });
            });
        });

        $expectedArray = [
            'match' => [
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
                "match": {
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

        $query = new MatchRule();
        $query->filter($filterRule);

        $expectedArray = [
            'match' => [
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
                "match": {
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
    public function it_can_have_use_field_on_the_query()
    {
        $query = new MatchRule();
        $query->useField('use-field');

        $expectedArray = [
            'match' => [
                'use_field' => 'use-field'
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "match": {
                    "use_field": "use-field"
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }
}
