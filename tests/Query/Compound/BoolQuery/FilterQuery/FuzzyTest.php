<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Compound\BoolQuery\FilterQuery;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\FuzzyQueryInterface;
use PHPUnit\Framework\TestCase;

class FuzzyTest extends TestCase
{
    /**
     * @test
     */
    public function test()
    {
        $query = new FilterQuery();
        $query->fuzzy(function (FuzzyQueryInterface $fuzzyQuery) {
            $fuzzyQuery->field('user')->value('John');
        });

        $expected = [
            'fuzzy' => [
                'user' => 'John',
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
