<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Compound;

use Hypefactors\ElasticBuilder\Query\Compound\DisjunctionMaxQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;
use PHPUnit\Framework\TestCase;

class DisjunctionMaxQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_applies_the_filter_clause_to_the_query()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $query = new DisjunctionMaxQuery();
        $query->query($termQuery);
        $query->tieBreaker(0.7);

        $expected = [
            'dis_max' => [
                'queries' => [
                    [
                        'term' => [
                            'user' => 'john',
                        ],
                    ],
                ],
                'tie_breaker' => 0.7,
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
