<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Compound\BoolQuery\FilterQuery;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\RangeQueryInterface;
use PHPUnit\Framework\TestCase;

class RangeTest extends TestCase
{
    /**
     * @test
     */
    public function test_1()
    {
        $query = new FilterQuery();
        $query->range(function (RangeQueryInterface $rangeQuery) {
            $rangeQuery->field('user')->gte('10');
        });

        $expected = [
            'range' => [
                'user' => [
                    'gte' => '10',
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
