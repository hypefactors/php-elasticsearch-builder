<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText\IntervalQueryRule;

use Hypefactors\ElasticBuilder\Query\FullText\IntervalQueryRule\FuzzyRule;
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

        $expectedArray = [
            'fuzzy' => [
                'term' => 'my-term'
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fuzzy": {
                    "term": "my-term"
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_have_prefix_length_on_the_query()
    {
        $query = new FuzzyRule();
        $query->prefixLength(123);

        $expectedArray = [
            'fuzzy' => [
                'prefix_length' => 123
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fuzzy": {
                    "prefix_length": 123
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_have_transpositions_enabled_on_the_query()
    {
        $query = new FuzzyRule();
        $query->transpositions(true);

        $expectedArray = [
            'fuzzy' => [
                'transpositions' => true
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fuzzy": {
                    "transpositions": true
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_have_transpositions_disabled_on_the_query()
    {
        $query = new FuzzyRule();
        $query->transpositions(false);

        $expectedArray = [
            'fuzzy' => [
                'transpositions' => false
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fuzzy": {
                    "transpositions": false
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
        $query = new FuzzyRule();
        $query->analyzer('analyzer-string');

        $expectedArray = [
            'fuzzy' => [
                'analyzer' => 'analyzer-string'
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fuzzy": {
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
        $query = new FuzzyRule();
        $query->useField('use-field');

        $expectedArray = [
            'fuzzy' => [
                'use_field' => 'use-field'
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fuzzy": {
                    "use_field": "use-field"
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }
}
