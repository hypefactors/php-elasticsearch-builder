<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQueryInterface;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\AllOfRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\AnyOfRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule\AfterRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FuzzyRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\MatchRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\PrefixRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\WildcardRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQuery;
use Hypefactors\ElasticBuilder\QueryBuilder;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;

class IntervalsQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_an_empty_query()
    {
        $intervalsQuery = new IntervalsQuery();
        $intervalsQuery->field('description');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($intervalsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($intervalsQuery) {
                $query->intervals($intervalsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [];

        $this->assertArrayHasKey('took', $response);
        $this->assertTrue($intervalsQuery->isEmpty());
        $this->assertSame($expected, $intervalsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_match_as_a_callable()
    {
        $intervalsQuery = new IntervalsQuery();
        $intervalsQuery->field('description');
        $intervalsQuery->match(function (MatchRule $query) {
            $query->query('my-query');
        });

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($intervalsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($intervalsQuery) {
                $query->intervals($intervalsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'intervals' => [
                'description' => [
                    'match' => [
                        'query' => 'my-query',
                    ],
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($intervalsQuery->isEmpty());
        $this->assertSame($expected, $intervalsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_match_as_a_class()
    {
        $matchRule = new MatchRule();
        $matchRule->query('my-query');

        $intervalsQuery = new IntervalsQuery();
        $intervalsQuery->field('description');
        $intervalsQuery->match($matchRule);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($intervalsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($intervalsQuery) {
                $query->intervals($intervalsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'intervals' => [
                'description' => [
                    'match' => [
                        'query' => 'my-query',
                    ],
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($intervalsQuery->isEmpty());
        $this->assertSame($expected, $intervalsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_prefix_as_a_callable()
    {
        $intervalsQuery = new IntervalsQuery();
        $intervalsQuery->field('description');
        $intervalsQuery->prefix(function (PrefixRule $query) {
            $query->prefix('prefix-here');
        });

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($intervalsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($intervalsQuery) {
                $query->intervals($intervalsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'intervals' => [
                'description' => [
                    'prefix' => [
                        'prefix' => 'prefix-here',
                    ],
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($intervalsQuery->isEmpty());
        $this->assertSame($expected, $intervalsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_prefix_as_a_class()
    {
        $prefixRule = new PrefixRule();
        $prefixRule->prefix('prefix-here');

        $intervalsQuery = new IntervalsQuery();
        $intervalsQuery->field('description');
        $intervalsQuery->prefix($prefixRule);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($intervalsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($intervalsQuery) {
                $query->intervals($intervalsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'intervals' => [
                'description' => [
                    'prefix' => [
                        'prefix' => 'prefix-here',
                    ],
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($intervalsQuery->isEmpty());
        $this->assertSame($expected, $intervalsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_wildcard_as_a_callable()
    {
        $intervalsQuery = new IntervalsQuery();
        $intervalsQuery->field('description');
        $intervalsQuery->wildcard(function (WildcardRule $query) {
            $query->pattern('pattern-here');
        });

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($intervalsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($intervalsQuery) {
                $query->intervals($intervalsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'intervals' => [
                'description' => [
                    'wildcard' => [
                        'pattern' => 'pattern-here',
                    ],
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($intervalsQuery->isEmpty());
        $this->assertSame($expected, $intervalsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_wildcard_as_a_class()
    {
        $wildcardRule = new WildcardRule();
        $wildcardRule->pattern('pattern-here');

        $intervalsQuery = new IntervalsQuery();
        $intervalsQuery->field('description');
        $intervalsQuery->wildcard($wildcardRule);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($intervalsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($intervalsQuery) {
                $query->intervals($intervalsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'intervals' => [
                'description' => [
                    'wildcard' => [
                        'pattern' => 'pattern-here',
                    ],
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($intervalsQuery->isEmpty());
        $this->assertSame($expected, $intervalsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_fuzzy_as_a_callable()
    {
        $intervalsQuery = new IntervalsQuery();
        $intervalsQuery->field('description');
        $intervalsQuery->fuzzy(function (FuzzyRule $query) {
            $query->term('term-here');
        });

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($intervalsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($intervalsQuery) {
                $query->intervals($intervalsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'intervals' => [
                'description' => [
                    'fuzzy' => [
                        'term' => 'term-here',
                    ],
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($intervalsQuery->isEmpty());
        $this->assertSame($expected, $intervalsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_fuzzy_as_a_class()
    {
        $fuzzyRule = new FuzzyRule();
        $fuzzyRule->term('term-here');

        $intervalsQuery = new IntervalsQuery();
        $intervalsQuery->field('description');
        $intervalsQuery->fuzzy($fuzzyRule);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($intervalsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($intervalsQuery) {
                $query->intervals($intervalsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'intervals' => [
                'description' => [
                    'fuzzy' => [
                        'term' => 'term-here',
                    ],
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($intervalsQuery->isEmpty());
        $this->assertSame($expected, $intervalsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_all_of_as_a_callable()
    {
        $intervalsQuery = new IntervalsQuery();
        $intervalsQuery->field('description');
        $intervalsQuery->allOf(function (AllOfRule $query) {
            $intervalsQuery = new IntervalsQuery();
            $intervalsQuery->match(fn (MatchRule $q) => $q->query('query 1'));

            $query->intervals($intervalsQuery);
        });

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($intervalsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($intervalsQuery) {
                $query->intervals($intervalsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'intervals' => [
                'description' => [
                    'all_of' => [
                        'intervals' => [
                            [
                                'match' => [
                                    'query' => 'query 1',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($intervalsQuery->isEmpty());
        $this->assertSame($expected, $intervalsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_all_of_as_a_class()
    {
        $allOffIntervalsQuery = new IntervalsQuery();
        $allOffIntervalsQuery->match(fn (MatchRule $q) => $q->query('query 1'));

        $allOfRule = new AllOfRule();
        $allOfRule->intervals($allOffIntervalsQuery);

        $intervalsQuery = new IntervalsQuery();
        $intervalsQuery->field('description');
        $intervalsQuery->allOf($allOfRule);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($intervalsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($intervalsQuery) {
                $query->intervals($intervalsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'intervals' => [
                'description' => [
                    'all_of' => [
                        'intervals' => [
                            [
                                'match' => [
                                    'query' => 'query 1',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($intervalsQuery->isEmpty());
        $this->assertSame($expected, $intervalsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_any_of_as_a_callable()
    {
        $intervalsQuery = new IntervalsQuery();
        $intervalsQuery->field('description');
        $intervalsQuery->anyOf(function (AnyOfRule $query) {
            $intervalsQuery = new IntervalsQuery();
            $intervalsQuery->match(fn (MatchRule $q) => $q->query('query 1'));

            $query->intervals($intervalsQuery);
        });

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($intervalsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($intervalsQuery) {
                $query->intervals($intervalsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'intervals' => [
                'description' => [
                    'any_of' => [
                        'intervals' => [
                            [
                                'match' => [
                                    'query' => 'query 1',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($intervalsQuery->isEmpty());
        $this->assertSame($expected, $intervalsQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_using_any_of_as_a_class()
    {
        $anyOffIntervalsQuery = new IntervalsQuery();
        $anyOffIntervalsQuery->match(fn (MatchRule $q) => $q->query('query 1'));

        $anyOfRule = new AnyOfRule();
        $anyOfRule->intervals($anyOffIntervalsQuery);

        $intervalsQuery = new IntervalsQuery();
        $intervalsQuery->field('description');
        $intervalsQuery->anyOf($anyOfRule);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($intervalsQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($intervalsQuery) {
                $query->intervals($intervalsQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'intervals' => [
                'description' => [
                    'any_of' => [
                        'intervals' => [
                            [
                                'match' => [
                                    'query' => 'query 1',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($intervalsQuery->isEmpty());
        $this->assertSame($expected, $intervalsQuery->build());
    }
}
