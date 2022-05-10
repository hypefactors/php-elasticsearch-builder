<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Core;

use Hypefactors\ElasticBuilder\Core\Script;
use Hypefactors\ElasticBuilder\Core\Sort;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;
use InvalidArgumentException;
use stdClass;

class SortTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_set_the_field_without_order()
    {
        $sort = new Sort();
        $sort->field('name');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->sort($sort);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'name' => new stdClass(),
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($sort->isEmpty());
        $this->assertEquals($expected, $sort->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_order()
    {
        $sort = new Sort();
        $sort->field('name');
        $sort->order('desc');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->sort($sort);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'name' => 'desc',
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($sort->isEmpty());
        $this->assertSame($expected, $sort->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_missing()
    {
        $sort = new Sort();
        $sort->field('name');
        $sort->missing('_last');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->sort($sort);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'name' => [
                'missing' => '_last',
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($sort->isEmpty());
        $this->assertSame($expected, $sort->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_sorting_mode()
    {
        $sort = new Sort();
        $sort->field('age');
        $sort->mode('avg');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->sort($sort);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'age' => [
                'mode' => 'avg',
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($sort->isEmpty());
        $this->assertSame($expected, $sort->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_sorting_mode_with_the_order()
    {
        $sort = new Sort();
        $sort->field('age');
        $sort->order('desc');
        $sort->mode('avg');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->sort($sort);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'age' => [
                'order' => 'desc',
                'mode'  => 'avg',
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($sort->isEmpty());
        $this->assertSame($expected, $sort->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_sorting_numeric_type()
    {
        $sort = new Sort();
        $sort->field('age');
        $sort->numericType('long');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->sort($sort);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'age' => [
                'numeric_type' => 'long',
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($sort->isEmpty());
        $this->assertSame($expected, $sort->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_sorting_unmapped_type()
    {
        $sort = new Sort();
        $sort->field('name');
        $sort->unmappedType('long');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->sort($sort);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'name' => [
                'unmapped_type' => 'long',
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($sort->isEmpty());
        $this->assertSame($expected, $sort->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_sorting_with_a_script()
    {
        $script = new Script();
        $script->language('painless');
        $script->source("doc['name'].value * params.factor");
        $script->parameters([
            'factor' => 1.1,
        ]);

        $sort = new Sort();
        $sort->order('desc');
        $sort->script($script);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->sort($sort);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            '_script' => [
                'order'  => 'desc',
                'type'   => 'number',
                'script' => [
                    'lang'   => 'painless',
                    'source' => "doc['name'].value * params.factor",
                    'params' => [
                        'factor' => 1.1,
                    ],
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($sort->isEmpty());
        $this->assertSame($expected, $sort->build());
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_when_generating_the_body_without_a_field()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $sort = new Sort();
        $sort->build();
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
