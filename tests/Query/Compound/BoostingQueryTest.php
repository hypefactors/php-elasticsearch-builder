<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Compound;

use Hypefactors\ElasticBuilder\Query\Compound\BoostingQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;
use PHPUnit\Framework\TestCase;

class BoostingQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $query = new BoostingQuery();
        $query->positive($termQuery);
        $query->negative($termQuery);
        $query->negativeBoost(2);

        $expected = [
            'boosting' => [
                'positive' => [
                    'term' => [
                        'user' => 'john',
                    ],
                ],
                'negative' => [
                    'term' => [
                        'user' => 'john',
                    ],
                ],
                'negative_boost' => 2,
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
