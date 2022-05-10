<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalsQueryRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\AnyOfRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule\NotContainingRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\MatchRule;
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

        $expected = [
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

        $query = new AnyOfRule();
        $query->intervals($intervalsQuery);

        $expected = [
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

        $this->assertSame($expected, $query->build());
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

        $expected = [
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

        $query = new AnyOfRule();
        $query->filter($filterRule);

        $expected = [
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

        $this->assertSame($expected, $query->build());
    }
}
