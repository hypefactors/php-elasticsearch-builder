<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Compound\BoolQuery\FilterQuery;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermsSetQueryInterface;
use PHPUnit\Framework\TestCase;

class TermsSetTest extends TestCase
{
    /**
     * @test
     */
    public function test_1()
    {
        $query = new FilterQuery();
        $query->termsSet(function (TermsSetQueryInterface $termQuery) {
            $termQuery->field('user')->term('John')->minimumShouldMatchField('required_matches');
        });

        $expected = [
            'terms_set' => [
                'user' => [
                    'terms' => [
                        'John',
                    ],
                    'minimum_should_match_field' => 'required_matches',
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
        $query->termsSet(function (TermsSetQueryInterface $termQuery) {
            $termQuery->field('user')->terms(['John'])->minimumShouldMatchField('required_matches');
        });

        $expected = [
            'terms_set' => [
                'user' => [
                    'terms' => [
                        'John',
                    ],
                    'minimum_should_match_field' => 'required_matches',
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
