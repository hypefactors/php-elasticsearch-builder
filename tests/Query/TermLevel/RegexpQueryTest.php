<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\TermLevel\RegexpQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RegexpQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');

        $expectedArray = [
            'regexp' => [
                'name.first' => 's.*',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "regexp": {
                    "name.first": "s.*"
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
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');
        $query->boost(1.5);

        $expectedArray = [
            'regexp' => [
                'name.first' => [
                    'value' => 's.*',
                    'boost' => 1.5,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "regexp": {
                    "name.first": {
                        "value": "s.*",
                        "boost": 1.5
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
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');
        $query->name('my-query-name');

        $expectedArray = [
            'regexp' => [
                'name.first' => [
                    'value' => 's.*',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "regexp": {
                    "name.first": {
                        "value": "s.*",
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
    public function it_builds_the_query_with_the_flags_parameter_from_a_string()
    {
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');
        $query->flags('INTERSECTION|COMPLEMENT|EMPTY');

        $expectedArray = [
            'regexp' => [
                'name.first' => [
                    'value' => 's.*',
                    'flags' => 'INTERSECTION|COMPLEMENT|EMPTY',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "regexp": {
                    "name.first": {
                        "value": "s.*",
                        "flags": "INTERSECTION|COMPLEMENT|EMPTY"
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
    public function it_builds_the_query_with_the_flags_parameter_from_an_array()
    {
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');
        $query->flags(['INTERSECTION', 'COMPLEMENT', 'EMPTY']);

        $expectedArray = [
            'regexp' => [
                'name.first' => [
                    'value' => 's.*',
                    'flags' => 'INTERSECTION|COMPLEMENT|EMPTY',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "regexp": {
                    "name.first": {
                        "value": "s.*",
                        "flags": "INTERSECTION|COMPLEMENT|EMPTY"
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
    public function it_builds_the_query_with_the_max_determinized_states_parameter()
    {
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');
        $query->maxDeterminizedStates(5);

        $expectedArray = [
            'regexp' => [
                'name.first' => [
                    'value'                   => 's.*',
                    'max_determinized_states' => 5,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "regexp": {
                    "name.first": {
                        "value": "s.*",
                        "max_determinized_states": 5
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
    public function it_builds_the_query_with_the_rewrite_parameter()
    {
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');
        $query->rewrite('rewrite');

        $expectedArray = [
            'regexp' => [
                'name.first' => [
                    'value'   => 's.*',
                    'rewrite' => 'rewrite',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "regexp": {
                    "name.first": {
                        "value": "s.*",
                        "rewrite": "rewrite"
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
    public function an_exception_will_be_thrown_if_there_are_invalid_flags()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The given flags are invalid: FOO, BAR');

        $query = new RegexpQuery();
        $query->flags(['foo', 'COMPLEMENT', 'bAr']);
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new RegexpQuery();
        $query->toArray();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_value_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "value" is required!');

        $query = new RegexpQuery();
        $query->field('name.first');

        $query->toArray();
    }
}
