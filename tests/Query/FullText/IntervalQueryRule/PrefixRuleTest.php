<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalQueryRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\PrefixRule;
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

        $expectedArray = [
            'prefix' => [
                'prefix' => 'my-prefix'
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "prefix": {
                    "prefix": "my-prefix"
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_have_analyzer_on_the_query()
    {
        $query = new PrefixRule();
        $query->analyzer('analyzer-string');

        $expectedArray = [
            'prefix' => [
                'analyzer' => 'analyzer-string'
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "prefix": {
                    "analyzer": "analyzer-string"
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_have_use_field_on_the_query()
    {
        $query = new PrefixRule();
        $query->useField('use-field');

        $expectedArray = [
            'prefix' => [
                'use_field' => 'use-field'
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "prefix": {
                    "use_field": "use-field"
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }
}
