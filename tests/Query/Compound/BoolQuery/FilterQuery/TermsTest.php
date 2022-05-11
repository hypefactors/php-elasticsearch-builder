<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Compound\BoolQuery\FilterQuery;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermsQueryInterface;
use PHPUnit\Framework\TestCase;

class TermsTest extends TestCase
{
    /**
     * @test
     */
    public function test_1()
    {
        $query = new FilterQuery();
        $query->terms(function (TermsQueryInterface $termQuery) {
            $termQuery->field('user')->value('John');
        });

        $expected = [
            'terms' => [
                'user' => [
                    'John',
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function test_2()
    {
        $query = new FilterQuery();
        $query->terms(function (TermsQueryInterface $termQuery) {
            $termQuery->field('user')->values(['John']);
        });

        $expected = [
            'terms' => [
                'user' => [
                    'John',
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
