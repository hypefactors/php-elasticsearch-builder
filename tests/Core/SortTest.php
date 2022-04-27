<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Core;

use Hypefactors\ElasticBuilder\Core\Sort;
use Hypefactors\ElasticBuilder\Script\Script;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;

class SortTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_set_the_field_without_order()
    {
        $sort = new Sort();
        $sort->field('my-field');

        $expectedArray = [
            'my-field' => new stdClass(),
        ];

        $expectedJson = <<<'JSON'
            {
                "my-field": {}
            }
            JSON;

        $this->assertEquals($expectedArray, $sort->toArray());
        $this->assertSame($expectedJson, $sort->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_order()
    {
        $sort = new Sort();
        $sort->field('my-field');
        $sort->order('desc');

        $expectedArray = [
            'my-field' => 'desc',
        ];

        $expectedJson = <<<'JSON'
            {
                "my-field": "desc"
            }
            JSON;

        $this->assertSame($expectedArray, $sort->toArray());
        $this->assertSame($expectedJson, $sort->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_missing()
    {
        $sort = new Sort();
        $sort->field('my-field');
        $sort->missing('_last');

        $expectedArray = [
            'my-field' => [
                'missing' => '_last',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "my-field": {
                    "missing": "_last"
                }
            }
            JSON;

        $this->assertSame($expectedArray, $sort->toArray());
        $this->assertSame($expectedJson, $sort->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_sorting_mode()
    {
        $sort = new Sort();
        $sort->field('my-field');
        $sort->mode('avg');

        $expectedArray = [
            'my-field' => [
                'mode' => 'avg',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "my-field": {
                    "mode": "avg"
                }
            }
            JSON;

        $this->assertSame($expectedArray, $sort->toArray());
        $this->assertSame($expectedJson, $sort->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_sorting_mode_with_the_order()
    {
        $sort = new Sort();
        $sort->field('my-field');
        $sort->order('desc');
        $sort->mode('avg');

        $expectedArray = [
            'my-field' => [
                'order' => 'desc',
                'mode'  => 'avg',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "my-field": {
                    "order": "desc",
                    "mode": "avg"
                }
            }
            JSON;

        $this->assertSame($expectedArray, $sort->toArray());
        $this->assertSame($expectedJson, $sort->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_sorting_numeric_type()
    {
        $sort = new Sort();
        $sort->field('my-field');
        $sort->numericType('long');

        $expectedArray = [
            'my-field' => [
                'numeric_type' => 'long',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "my-field": {
                    "numeric_type": "long"
                }
            }
            JSON;

        $this->assertSame($expectedArray, $sort->toArray());
        $this->assertSame($expectedJson, $sort->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_sorting_unmapped_type()
    {
        $sort = new Sort();
        $sort->field('my-field');
        $sort->unmappedType('long');

        $expectedArray = [
            'my-field' => [
                'unmapped_type' => 'long',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "my-field": {
                    "unmapped_type": "long"
                }
            }
            JSON;

        $this->assertSame($expectedArray, $sort->toArray());
        $this->assertSame($expectedJson, $sort->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_sorting_with_a_script()
    {
        $script = new Script();
        $script->language('painless');
        $script->source("doc['field_name'].value * params.factor");
        $script->parameters([
            'factor' => 1.1,
        ]);

        $sort = new Sort();
        $sort->order('desc');
        $sort->script($script);

        $expectedArray = [
            '_script' => [
                'order'  => 'desc',
                'script' => [
                    'lang'   => 'painless',
                    'source' => "doc['field_name'].value * params.factor",
                    'params' => [
                        'factor' => 1.1,
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "_script": {
                    "order": "desc",
                    "script": {
                        "lang": "painless",
                        "source": "doc['field_name'].value * params.factor",
                        "params": {
                            "factor": 1.1
                        }
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $sort->toArray());
        $this->assertSame($expectedJson, $sort->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_when_generating_the_body_without_a_field()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $sort = new Sort();
        $sort->toArray();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_when_setting_an_invalid_order()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [foo] order is invalid!');

        $sort = new Sort();
        $sort->order('foo');
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_when_setting_an_invalid_mode()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [foo] mode is invalid!');

        $sort = new Sort();
        $sort->mode('foo');
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_when_setting_an_invalid_numeric_type()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [foo] numeric type is invalid!');

        $sort = new Sort();
        $sort->numericType('foo');
    }
}
