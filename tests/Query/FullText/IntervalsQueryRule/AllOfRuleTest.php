<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalsQueryRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\AllOfRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule\NotContainingRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\MatchRule;
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

        $expected = [
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

        $this->assertSame($expected, $query->build());
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

        $expected = [
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

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_can_have_max_gaps_on_the_query()
    {
        $query = new AllOfRule();
        $query->maxGaps(1);

        $expected = [
            'all_of' => [
                'max_gaps' => 1,
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_can_have_ordered_enabled_on_the_query()
    {
        $query = new AllOfRule();
        $query->ordered(true);

        $expected = [
            'all_of' => [
                'ordered' => true,
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_can_have_ordered_disabled_on_the_query()
    {
        $query = new AllOfRule();
        $query->ordered(false);

        $expected = [
            'all_of' => [
                'ordered' => false,
            ],
        ];

        $this->assertSame($expected, $query->build());
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

        $expected = [
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

        $this->assertSame($expected, $query->build());
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

        $expected = [
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

        $this->assertSame($expected, $query->build());
    }
}
