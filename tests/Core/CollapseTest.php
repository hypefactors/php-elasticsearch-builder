<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Core;

use Hypefactors\ElasticBuilder\Core\Collapse;
use Hypefactors\ElasticBuilder\Core\InnerHits;
use Hypefactors\ElasticBuilder\Core\InnerHitsInterface;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;
use InvalidArgumentException;

class CollapseTest extends TestCase
{
    /**
     * @test
     */
    public function the_field_can_be_set()
    {
        $collapse = new Collapse();
        $collapse->field('name');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->collapse($collapse);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'field' => 'name',
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($collapse->isEmpty());
        $this->assertEquals($expected, $collapse->build());
    }

    /**
     * @test
     */
    public function the_inner_hits_can_be_applied_using_a_class_instance()
    {
        $innerHits = new InnerHits();
        $innerHits->name('named-query');

        $collapse = new Collapse();
        $collapse->field('name');
        $collapse->innerHits($innerHits);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->collapse($collapse);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'field' => 'name',
            'inner_hits' => [
                'name' => 'named-query',
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($collapse->isEmpty());
        $this->assertSame($expected, $collapse->build());
    }

    /**
     * @test
     */
    public function the_inner_hits_can_be_applied_using_a_closure()
    {
        $collapse = new Collapse();
        $collapse->field('name');
        $collapse->innerHits(function (InnerHitsInterface $query) {
            $query->name('named-query');
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->collapse($collapse);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'field' => 'name',
            'inner_hits' => [
                'name' => 'named-query',
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($collapse->isEmpty());
        $this->assertSame($expected, $collapse->build());
    }

    /**
     * @test
     */
    public function the_max_concurrent_group_searches_can_be_set()
    {
        $collapse = new Collapse();
        $collapse->field('name');
        $collapse->maxConcurrentGroupSearches(1);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->collapse($collapse);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'field' => 'name',
            'max_concurrent_group_searches' => 1,
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($collapse->isEmpty());
        $this->assertEquals($expected, $collapse->build());
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $collapse = new Collapse();
        $collapse->build();
    }
}
