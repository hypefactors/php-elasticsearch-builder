<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Compound\BoolQuery\FilterQuery;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\RegexpQueryInterface;
use PHPUnit\Framework\TestCase;

class RegexpTest extends TestCase
{
    /**
     * @test
     */
    public function test()
    {
        $query = new FilterQuery();
        $query->regexp(function (RegexpQueryInterface $regexpQuery) {
            $regexpQuery->field('user')->value('John');
        });

        $expected = [
            'regexp' => [
                'user' => 'John',
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
