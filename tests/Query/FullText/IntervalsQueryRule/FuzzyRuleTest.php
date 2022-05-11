<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalsQueryRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FuzzyRule;
use PHPUnit\Framework\TestCase;

class FuzzyRuleTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_have_term_on_the_query()
    {
        $query = new FuzzyRule();
        $query->term('my-term');

        $expected = [
            'fuzzy' => [
                'term' => 'my-term',
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_can_have_prefix_length_on_the_query()
    {
        $query = new FuzzyRule();
        $query->prefixLength(123);

        $expected = [
            'fuzzy' => [
                'prefix_length' => 123,
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_can_have_transpositions_enabled_on_the_query()
    {
        $query = new FuzzyRule();
        $query->transpositions(true);

        $expected = [
            'fuzzy' => [
                'transpositions' => true,
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_can_have_transpositions_disabled_on_the_query()
    {
        $query = new FuzzyRule();
        $query->transpositions(false);

        $expected = [
            'fuzzy' => [
                'transpositions' => false,
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_can_have_analyzer_on_the_query()
    {
        $query = new FuzzyRule();
        $query->analyzer('analyzer-string');

        $expected = [
            'fuzzy' => [
                'analyzer' => 'analyzer-string',
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_can_have_use_field_on_the_query()
    {
        $query = new FuzzyRule();
        $query->useField('use-field');

        $expected = [
            'fuzzy' => [
                'use_field' => 'use-field',
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
