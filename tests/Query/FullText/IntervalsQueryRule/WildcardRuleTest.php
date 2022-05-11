<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalsQueryRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\WildcardRule;
use PHPUnit\Framework\TestCase;

class WildcardRuleTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_have_pattern_on_the_query()
    {
        $query = new WildcardRule();
        $query->pattern('my-pattern');

        $expected = [
            'wildcard' => [
                'pattern' => 'my-pattern',
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_can_have_analyzer_on_the_query()
    {
        $query = new WildcardRule();
        $query->analyzer('analyzer-string');

        $expected = [
            'wildcard' => [
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
        $query = new WildcardRule();
        $query->useField('use-field');

        $expected = [
            'wildcard' => [
                'use_field' => 'use-field',
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
