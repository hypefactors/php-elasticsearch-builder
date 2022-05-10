<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Compound\BoolQuery\FilterQuery;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\IdsQueryInterface;
use PHPUnit\Framework\TestCase;

class IdsTest extends TestCase
{
    /**
     * @test
     */
    public function test()
    {
        $query = new FilterQuery();
        $query->ids(function (IdsQueryInterface $idsQuery) {
            $idsQuery->values(['id1', 'id2']);
        });

        $expected = [
            'ids' => [
                'values' => [
                    'id1',
                    'id2',
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
