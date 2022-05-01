<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Core;

use Hypefactors\ElasticBuilder\Core\Collapse;
use Hypefactors\ElasticBuilder\Core\InnerHits;
use Hypefactors\ElasticBuilder\Core\InnerHitsInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CollapseTest extends TestCase
{
    /**
     * @test
     */
    public function the_field_can_be_set()
    {
        $collapse = new Collapse();
        $collapse->field('my-field');

        $expectedArray = [
            'field' => 'my-field',
        ];

        $expectedJson = <<<'JSON'
            {
                "field": "my-field"
            }
            JSON;

        $this->assertFalse($collapse->isEmpty());
        $this->assertEquals($expectedArray, $collapse->toArray());
        $this->assertSame($expectedJson, $collapse->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function the_inner_hits_can_be_applied_using_the_class_instance()
    {
        $innerHits = new InnerHits();
        $innerHits->name('named-query');

        $collapse = new Collapse();
        $collapse->field('my-field');
        $collapse->innerHits($innerHits);

        $expectedArray = [
            'field' => 'my-field',
            'inner_hits' => [
                'name' => 'named-query',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "field": "my-field",
                "inner_hits": {
                    "name": "named-query"
                }
            }
            JSON;

        $this->assertFalse($collapse->isEmpty());
        $this->assertSame($expectedArray, $collapse->toArray());
        $this->assertSame($expectedJson, $collapse->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function the_inner_hits_can_be_applied_using_a_closure()
    {
        $collapse = new Collapse();
        $collapse->field('my-field');
        $collapse->innerHits(function (InnerHitsInterface $query) {
            $query->name('named-query');
        });

        $expectedArray = [
            'field' => 'my-field',
            'inner_hits' => [
                'name' => 'named-query',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "field": "my-field",
                "inner_hits": {
                    "name": "named-query"
                }
            }
            JSON;

        $this->assertFalse($collapse->isEmpty());
        $this->assertSame($expectedArray, $collapse->toArray());
        $this->assertSame($expectedJson, $collapse->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function the_max_concurrent_group_searches_can_be_set()
    {
        $collapse = new Collapse();
        $collapse->field('my-field');
        $collapse->maxConcurrentGroupSearches(1);

        $expectedArray = [
            'field' => 'my-field',
            'max_concurrent_group_searches' => 1,
        ];

        $expectedJson = <<<'JSON'
            {
                "field": "my-field",
                "max_concurrent_group_searches": 1
            }
            JSON;

        $this->assertFalse($collapse->isEmpty());
        $this->assertEquals($expectedArray, $collapse->toArray());
        $this->assertSame($expectedJson, $collapse->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $collapse = new Collapse();
        $collapse->toArray();
    }
}
