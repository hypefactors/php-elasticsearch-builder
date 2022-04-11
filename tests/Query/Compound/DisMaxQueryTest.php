<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Compound;

use Hypefactors\ElasticBuilder\Query\Compound\DisMaxQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;
use PHPUnit\Framework\TestCase;

class DisMaxQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_applies_the_filter_clause_to_the_query()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $query = new DisMaxQuery();
        $query->queries($termQuery);
        $query->tieBreaker(0.7);

        $expectedArray = [
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

        $expectedJson = <<<'JSON'
            {
                "dis_max": {
                    "queries": [
                        {
                            "term": {
                                "user": "john"
                            }
                        }
                    ],
                    "tie_breaker": 0.7
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }
}
