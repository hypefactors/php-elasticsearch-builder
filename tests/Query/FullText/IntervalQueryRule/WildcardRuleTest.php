<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalQueryRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\WildcardRule;
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

        $expectedArray = [
            'wildcard' => [
                'pattern' => 'my-pattern'
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "wildcard": {
                    "pattern": "my-pattern"
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
        $query = new WildcardRule();
        $query->analyzer('analyzer-string');

        $expectedArray = [
            'wildcard' => [
                'analyzer' => 'analyzer-string'
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "wildcard": {
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
        $query = new WildcardRule();
        $query->useField('use-field');

        $expectedArray = [
            'wildcard' => [
                'use_field' => 'use-field'
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "wildcard": {
                    "use_field": "use-field"
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }
}
