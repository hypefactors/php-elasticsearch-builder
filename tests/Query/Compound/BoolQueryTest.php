<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Compound;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQuery;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\MustNotQuery;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\MustQuery;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\ShouldQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\ExistsQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\ExistsQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQueryInterface;
use PHPUnit\Framework\TestCase;

class BoolQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_applies_the_filter_clause_to_the_query_using_a_closure()
    {
        $query = new BoolQuery();
        $query->filter(function (FilterQuery $query) {
            $query->term(function (TermQueryInterface $query) {
                $query->field('user')->value('john');
            });
            $query->exists(function (ExistsQueryInterface $query) {
                $query->field('user');
            });
        });

        $expected = [
            'bool' => [
                'filter' => [
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
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_applies_the_filter_clause_to_the_query_using_the_filter_query_class()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $existsQuery = new ExistsQuery();
        $existsQuery->field('user');

        $filterQuery = new FilterQuery();
        $filterQuery->term($termQuery);
        $filterQuery->exists($existsQuery);

        $query = new BoolQuery();
        $query->filter($filterQuery);

        $expected = [
            'bool' => [
                'filter' => [
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
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_applies_the_must_clause_to_the_query_using_a_closure()
    {
        $query = new BoolQuery();
        $query->must(function (MustQuery $query) {
            $query->term(function (TermQueryInterface $query) {
                $query->field('user')->value('john');
            });
            $query->exists(function (ExistsQueryInterface $query) {
                $query->field('user');
            });
        });

        $expected = [
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
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_applies_the_must_clause_to_the_query_using_the_must_query_class()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $existsQuery = new ExistsQuery();
        $existsQuery->field('user');

        $mustQuery = new MustQuery();
        $mustQuery->term($termQuery);
        $mustQuery->exists($existsQuery);

        $query = new BoolQuery();
        $query->must($mustQuery);

        $expected = [
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
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_applies_the_must_not_clause_to_the_query_using_closure()
    {
        $query = new BoolQuery();
        $query->mustNot(function (MustNotQuery $query) {
            $query->term(function (TermQueryInterface $query) {
                $query->field('user')->value('john');
            });
            $query->exists(function (ExistsQueryInterface $query) {
                $query->field('user');
            });
        });

        $expected = [
            'bool' => [
                'must_not' => [
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
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_applies_the_must_not_clause_to_the_query_using_the_must_not_query_class()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $existsQuery = new ExistsQuery();
        $existsQuery->field('user');

        $mustNotQuery = new MustNotQuery();
        $mustNotQuery->term($termQuery);
        $mustNotQuery->exists($existsQuery);

        $query = new BoolQuery();
        $query->mustNot($mustNotQuery);

        $expected = [
            'bool' => [
                'must_not' => [
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
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_applies_the_should_clause_to_the_query_using_a_closure()
    {
        $query = new BoolQuery();
        $query->should(function (ShouldQuery $query) {
            $query->term(function (TermQueryInterface $query) {
                $query->field('user')->value('john');
            });
            $query->exists(function (ExistsQueryInterface $query) {
                $query->field('user');
            });
        });

        $expected = [
            'bool' => [
                'should' => [
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
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_applies_the_should_clause_to_the_query_using_the_should_query_class()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $existsQuery = new ExistsQuery();
        $existsQuery->field('user');

        $shouldQuery = new ShouldQuery();
        $shouldQuery->term($termQuery);
        $shouldQuery->exists($existsQuery);

        $query = new BoolQuery();
        $query->should($shouldQuery);

        $expected = [
            'bool' => [
                'should' => [
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
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_can_combine_multiple_clauses_and_applies_them_to_the_query_using_closures()
    {
        $query = new BoolQuery();
        $query->filter(function (FilterQuery $query) {
            $query->term(function (TermQueryInterface $query) {
                $query->field('user-1')->value('John 1');
            });
        });
        $query->must(function (MustQuery $query) {
            $query->term(function (TermQueryInterface $query) {
                $query->field('user-2')->value('John 2');
            });
        });
        $query->should(function (ShouldQuery $query) {
            $query->term(function (TermQueryInterface $query) {
                $query->field('user-3')->value('John 3');
            });
        });
        $query->mustNot(function (MustNotQuery $query) {
            $query->term(function (TermQueryInterface $query) {
                $query->field('user-4')->value('John 4');
            });
        });
        $query->must(function (MustQuery $query) {
            $query->term(function (TermQueryInterface $query) {
                $query->field('user-5')->value('John 5');
            });
        });

        $expected = [
            'bool' => [
                'filter' => [
                    'term' => [
                        'user-1' => 'John 1',
                    ],
                ],
                'must' => [
                    [
                        'term' => [
                            'user-2' => 'John 2',
                        ],
                    ],
                    [
                        'term' => [
                            'user-5' => 'John 5',
                        ],
                    ],
                ],
                'should' => [
                    'term' => [
                        'user-3' => 'John 3',
                    ],
                ],
                'must_not' => [
                    'term' => [
                        'user-4' => 'John 4',
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_can_combine_multiple_clauses_and_applies_them_to_the_query_using_query_classes()
    {
        $termQuery1 = new TermQuery();
        $termQuery1->field('user-1')->value('John 1');

        $termQuery2 = new TermQuery();
        $termQuery2->field('user-2')->value('John 2');

        $termQuery3 = new TermQuery();
        $termQuery3->field('user-3')->value('John 3');

        $termQuery4 = new TermQuery();
        $termQuery4->field('user-4')->value('John 4');

        $termQuery5 = new TermQuery();
        $termQuery5->field('user-5')->value('John 5');

        $filterQuery = new FilterQuery();
        $filterQuery->term($termQuery1);

        $mustQuery1 = new MustQuery();
        $mustQuery1->term($termQuery2);

        $mustQuery2 = new MustQuery();
        $mustQuery2->term($termQuery5);

        $shouldQuery = new ShouldQuery();
        $shouldQuery->term($termQuery3);

        $mustNotQuery = new MustNotQuery();
        $mustNotQuery->term($termQuery4);

        $query = new BoolQuery();
        $query->filter($filterQuery);
        $query->must($mustQuery1);
        $query->should($shouldQuery);
        $query->mustNot($mustNotQuery);
        $query->must($mustQuery2);

        $expected = [
            'bool' => [
                'filter' => [
                    'term' => [
                        'user-1' => 'John 1',
                    ],
                ],
                'must' => [
                    [
                        'term' => [
                            'user-2' => 'John 2',
                        ],
                    ],
                    [
                        'term' => [
                            'user-5' => 'John 5',
                        ],
                    ],
                ],
                'should' => [
                    'term' => [
                        'user-3' => 'John 3',
                    ],
                ],
                'must_not' => [
                    'term' => [
                        'user-4' => 'John 4',
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
