<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Span;

use Hypefactors\ElasticBuilder\Query\Span\SpanTermQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class SpanTermQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $query = new SpanTermQuery();
        $query->field('user');
        $query->value('kimchy');

        $expectedArray = [
            'span_term' => [
                'user' => 'kimchy',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "span_term": {
                    "user": "kimchy"
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_boost_factor_parameter()
    {
        $query = new SpanTermQuery();
        $query->field('user');
        $query->value('kimchy');
        $query->boost(1.0);

        $expectedArray = [
            'span_term' => [
                'user' => [
                    'value' => 'kimchy',
                    'boost' => 1.0,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "span_term": {
                    "user": {
                        "value": "kimchy",
                        "boost": 1
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_name_parameter()
    {
        $query = new SpanTermQuery();
        $query->field('user');
        $query->value('kimchy');
        $query->name('my-query-name');

        $expectedArray = [
            'span_term' => [
                'user' => [
                    'value' => 'kimchy',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "span_term": {
                    "user": {
                        "value": "kimchy",
                        "_name": "my-query-name"
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new SpanTermQuery();
        $query->toArray();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_parameter_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "value" is required!');

        $query = new SpanTermQuery();
        $query->field('user');

        $query->toArray();
    }
}
