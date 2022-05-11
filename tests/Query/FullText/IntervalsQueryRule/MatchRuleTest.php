<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalsQueryRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FilterRule\NotContainingRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\MatchRule;
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

        $expected = [
            'match' => [
                'query' => 'my-query',
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_can_have_max_gaps_on_the_query()
    {
        $query = new MatchRule();
        $query->maxGaps(1);

        $expected = [
            'match' => [
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
        $query = new MatchRule();
        $query->ordered(true);

        $expected = [
            'match' => [
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
        $query = new MatchRule();
        $query->ordered(false);

        $expected = [
            'match' => [
                'ordered' => false,
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_can_have_analyzer_on_the_query()
    {
        $query = new MatchRule();
        $query->analyzer('analyzer-string');

        $expected = [
            'match' => [
                'analyzer' => 'analyzer-string',
            ],
        ];

        $this->assertSame($expected, $query->build());
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

        $expected = [
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

        $query = new MatchRule();
        $query->filter($filterRule);

        $expected = [
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

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_can_have_use_field_on_the_query()
    {
        $query = new MatchRule();
        $query->useField('use-field');

        $expected = [
            'match' => [
                'use_field' => 'use-field',
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
