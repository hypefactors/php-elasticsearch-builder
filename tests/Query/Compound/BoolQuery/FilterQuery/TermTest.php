<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Compound\BoolQuery\FilterQuery;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQueryInterface;
use PHPUnit\Framework\TestCase;

class TermTest extends TestCase
{
    /**
     * @test
     */
    public function test()
    {
        $query = new FilterQuery();
        $query->term(function (TermQueryInterface $termQuery) {
            $termQuery->field('user')->value('John');
        });

        $expected = [
            'term' => [
                'user' => 'John',
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
