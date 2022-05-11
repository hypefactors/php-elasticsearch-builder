<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Compound\BoolQuery\FilterQuery;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\WildcardQueryInterface;
use PHPUnit\Framework\TestCase;

class WildcardTest extends TestCase
{
    /**
     * @test
     */
    public function test()
    {
        $query = new FilterQuery();
        $query->wildcard(function (WildcardQueryInterface $wildcardQuery) {
            $wildcardQuery->field('user')->value('John');
        });

        $expected = [
            'wildcard' => [
                'user' => 'John',
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
