<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Compound\BoolQuery\FilterQuery;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\PrefixQueryInterface;
use PHPUnit\Framework\TestCase;

class PrefixTest extends TestCase
{
    /**
     * @test
     */
    public function test()
    {
        $query = new FilterQuery();
        $query->prefix(function (PrefixQueryInterface $prefixQuery) {
            $prefixQuery->field('user')->value('John');
        });

        $expected = [
            'prefix' => [
                'user' => 'John',
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
