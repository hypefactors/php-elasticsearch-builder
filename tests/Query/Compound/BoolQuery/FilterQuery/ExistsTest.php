<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Compound\BoolQuery\FilterQuery;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\ExistsQueryInterface;
use PHPUnit\Framework\TestCase;

class ExistsTest extends TestCase
{
    /**
     * @test
     */
    public function test()
    {
        $query = new FilterQuery();
        $query->exists(function (ExistsQueryInterface $existsQuery) {
            $existsQuery->field('user');
        });

        $expected = [
            'exists' => [
                'field' => 'user',
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
