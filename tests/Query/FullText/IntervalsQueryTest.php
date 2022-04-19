<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\AllOfRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\AnyOfRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FilterRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FuzzyRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\MatchRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\PrefixRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\WildcardRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQuery;
use PHPUnit\Framework\TestCase;

class IntervalsQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_an_empty_query()
    {
        $query = new IntervalsQuery();

        $expectedArray = [
            'intervals' => [],
        ];

        $expectedJson = <<<'JSON'
            {
                "intervals": []
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_match_as_a_callable()
    {
        $query = new IntervalsQuery();
        $query->match(function (MatchRule $query) {
            $query->boost(1);
        });

        $expectedArray = [
            'intervals' => [
                [
                    'match' => [
                        'boost' => 1.0,
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "intervals": [
                    {
                        "match": {
                            "boost": 1
                        }
                    }
                ]
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_match_as_a_class()
    {
        $matchRule = new MatchRule();
        $matchRule->boost(1);

        $query = new IntervalsQuery();
        $query->match($matchRule);

        $expectedArray = [
            'intervals' => [
                [
                    'match' => [
                        'boost' => 1.0,
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "intervals": [
                    {
                        "match": {
                            "boost": 1
                        }
                    }
                ]
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_prefix_as_a_callable()
    {
        $query = new IntervalsQuery();
        $query->prefix(function (PrefixRule $query) {
            $query->boost(1);
        });

        $expectedArray = [
            'intervals' => [
                [
                    'prefix' => [
                        'boost' => 1.0,
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "intervals": [
                    {
                        "prefix": {
                            "boost": 1
                        }
                    }
                ]
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_prefix_as_a_class()
    {
        $prefixRule = new PrefixRule();
        $prefixRule->boost(1);

        $query = new IntervalsQuery();
        $query->prefix($prefixRule);

        $expectedArray = [
            'intervals' => [
                [
                    'prefix' => [
                        'boost' => 1.0,
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "intervals": [
                    {
                        "prefix": {
                            "boost": 1
                        }
                    }
                ]
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_wildcard_as_a_callable()
    {
        $query = new IntervalsQuery();
        $query->wildcard(function (WildcardRule $query) {
            $query->boost(1);
        });

        $expectedArray = [
            'intervals' => [
                [
                    'wildcard' => [
                        'boost' => 1.0,
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "intervals": [
                    {
                        "wildcard": {
                            "boost": 1
                        }
                    }
                ]
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_wildcard_as_a_class()
    {
        $wildcardRule = new WildcardRule();
        $wildcardRule->boost(1);

        $query = new IntervalsQuery();
        $query->wildcard($wildcardRule);

        $expectedArray = [
            'intervals' => [
                [
                    'wildcard' => [
                        'boost' => 1.0,
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "intervals": [
                    {
                        "wildcard": {
                            "boost": 1
                        }
                    }
                ]
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_fuzzy_as_a_callable()
    {
        $query = new IntervalsQuery();
        $query->fuzzy(function (FuzzyRule $query) {
            $query->boost(1);
        });

        $expectedArray = [
            'intervals' => [
                [
                    'fuzzy' => [
                        'boost' => 1.0,
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "intervals": [
                    {
                        "fuzzy": {
                            "boost": 1
                        }
                    }
                ]
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_fuzzy_as_a_class()
    {
        $fuzzyRule = new FuzzyRule();
        $fuzzyRule->boost(1);

        $query = new IntervalsQuery();
        $query->fuzzy($fuzzyRule);

        $expectedArray = [
            'intervals' => [
                [
                    'fuzzy' => [
                        'boost' => 1.0,
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "intervals": [
                    {
                        "fuzzy": {
                            "boost": 1
                        }
                    }
                ]
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_all_of_as_a_callable()
    {
        $query = new IntervalsQuery();
        $query->allOf(function (AllOfRule $query) {
            $query->boost(1);
        });

        $expectedArray = [
            'intervals' => [
                [
                    'all_of' => [
                        'boost' => 1.0,
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "intervals": [
                    {
                        "all_of": {
                            "boost": 1
                        }
                    }
                ]
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_all_of_as_a_class()
    {
        $allOfRule = new AllOfRule();
        $allOfRule->boost(1);

        $query = new IntervalsQuery();
        $query->allOf($allOfRule);

        $expectedArray = [
            'intervals' => [
                [
                    'all_of' => [
                        'boost' => 1.0,
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "intervals": [
                    {
                        "all_of": {
                            "boost": 1
                        }
                    }
                ]
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_any_of_as_a_callable()
    {
        $query = new IntervalsQuery();
        $query->anyOf(function (AnyOfRule $query) {
            $query->boost(1);
        });

        $expectedArray = [
            'intervals' => [
                [
                    'any_of' => [
                        'boost' => 1.0,
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "intervals": [
                    {
                        "any_of": {
                            "boost": 1
                        }
                    }
                ]
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_any_of_as_a_class()
    {
        $anyOfRule = new AnyOfRule();
        $anyOfRule->boost(1);

        $query = new IntervalsQuery();
        $query->anyOf($anyOfRule);

        $expectedArray = [
            'intervals' => [
                [
                    'any_of' => [
                        'boost' => 1.0,
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "intervals": [
                    {
                        "any_of": {
                            "boost": 1
                        }
                    }
                ]
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_filter_as_a_callable()
    {
        $query = new IntervalsQuery();
        $query->filter(function (FilterRule $query) {
            $query->boost(1);
        });

        $expectedArray = [
            'intervals' => [
                [
                    'filter' => [
                        'boost' => 1.0,
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "intervals": [
                    {
                        "filter": {
                            "boost": 1
                        }
                    }
                ]
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_filter_as_a_class()
    {
        $filterRule = new FilterRule();
        $filterRule->boost(1);

        $query = new IntervalsQuery();
        $query->filter($filterRule);

        $expectedArray = [
            'intervals' => [
                [
                    'filter' => [
                        'boost' => 1.0,
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "intervals": [
                    {
                        "filter": {
                            "boost": 1
                        }
                    }
                ]
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }
}
