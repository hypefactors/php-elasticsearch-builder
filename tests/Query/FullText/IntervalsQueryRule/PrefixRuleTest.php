<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalsQueryRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\PrefixRule;
use PHPUnit\Framework\TestCase;

class PrefixRuleTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_have_prefix_on_the_query()
    {
        $query = new PrefixRule();
        $query->prefix('my-prefix');

        $expected = [
            'prefix' => [
                'prefix' => 'my-prefix',
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_can_have_analyzer_on_the_query()
    {
        $query = new PrefixRule();
        $query->analyzer('analyzer-string');

        $expected = [
            'prefix' => [
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
        $query = new PrefixRule();
        $query->useField('use-field');

        $expected = [
            'prefix' => [
                'use_field' => 'use-field',
            ],
        ];

        $this->assertSame($expected, $query->build());
    }
}
