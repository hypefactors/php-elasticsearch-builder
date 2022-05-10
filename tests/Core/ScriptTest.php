<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Core;

use Hypefactors\ElasticBuilder\Core\Script;
use Hypefactors\ElasticBuilder\Core\Sort;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;
use InvalidArgumentException;

class ScriptTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query_with_the_source_parameter()
    {
        $script = new Script();
        $script->source("doc['name'].value");

        $sort = new Sort();
        $sort->order('desc');
        $sort->script($script);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->sort($sort);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'source' => "doc['name'].value",
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($script->isEmpty());
        $this->assertSame($expected, $script->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_id_parameter()
    {
        $script = new Script();
        $script->id('ci-stored-script');

        $sort = new Sort();
        $sort->order('desc');
        $sort->script($script);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->sort($sort);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'id' => 'ci-stored-script',
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($script->isEmpty());
        $this->assertSame($expected, $script->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_language_parameter()
    {
        $script = new Script();
        $script->language('painless');
        $script->source("doc['name'].value");

        $sort = new Sort();
        $sort->order('desc');
        $sort->script($script);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->sort($sort);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'lang'   => 'painless',
            'source' => "doc['name'].value",
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($script->isEmpty());
        $this->assertSame($expected, $script->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_parameters_parameter()
    {
        $script = new Script();
        $script->source("doc['name'].value");
        $script->parameters([
            'multiplier' => 2,
        ]);

        $sort = new Sort();
        $sort->order('desc');
        $sort->script($script);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->sort($sort);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'source'     => "doc['name'].value",
                'params' => [
                'multiplier' => 2,
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($script->isEmpty());
        $this->assertSame($expected, $script->build());
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_source_or_id_are_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "source" or "id" is required!');

        $script = new Script();

        $script->build();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_both_source_ad_id_are_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Passing both "source" and "id" at the same time is not allowed.');

        $script = new Script();
        $script->id('my id');
        $script->source('script source');

        $script->build();
    }
}
