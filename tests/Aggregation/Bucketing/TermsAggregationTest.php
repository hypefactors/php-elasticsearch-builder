<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Aggregation\Bucketing;

use Hypefactors\ElasticBuilder\Aggregation\Bucketing\TermsAggregation;
use Hypefactors\ElasticBuilder\Core\Script;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TermsAggregationTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $aggregation = new TermsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');

        $expectedArray = [
            'genres' => [
                'terms' => [
                    'field' => 'genre',
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_metadata_parameter()
    {
        $aggregation = new TermsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->meta([
            'foo' => 'bar',
        ]);

        $expectedArray = [
            'genres' => [
                'terms' => [
                    'field' => 'genre',
                ],
                'meta' => [
                    'foo' => 'bar',
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_collect_mode_parameter()
    {
        $aggregation = new TermsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->collectMode('breadth_first');

        $expectedArray = [
            'genres' => [
                'terms' => [
                    'field'        => 'genre',
                    'collect_mode' => 'breadth_first',
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_order_parameter()
    {
        $aggregation = new TermsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->order('_count', 'asc');

        $expectedArray = [
            'genres' => [
                'terms' => [
                    'field' => 'genre',
                    'order' => [
                        ['_count' => 'asc'],
                    ],
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_script_parameter()
    {
        $script = new Script();
        $script->source('script source');
        $script->language('painless');

        $aggregation = new TermsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->script($script);

        $expectedArray = [
            'genres' => [
                'terms' => [
                    'field'  => 'genre',
                    'script' => [
                        'source' => 'script source',
                        'lang'   => 'painless',
                    ],
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_size_parameter()
    {
        $aggregation = new TermsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->size(5);

        $expectedArray = [
            'genres' => [
                'terms' => [
                    'field' => 'genre',
                    'size'  => 5,
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_shard_size_parameter()
    {
        $aggregation = new TermsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->shardSize(5);

        $expectedArray = [
            'genres' => [
                'terms' => [
                    'field'      => 'genre',
                    'shard_size' => 5,
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_show_term_doc_count_error_parameter()
    {
        $aggregation = new TermsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->showTermDocCountError(true);

        $expectedArray = [
            'genres' => [
                'terms' => [
                    'field'                     => 'genre',
                    'show_term_doc_count_error' => true,
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_min_doc_count_parameter()
    {
        $aggregation = new TermsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->minDocCount(5);

        $expectedArray = [
            'genres' => [
                'terms' => [
                    'field'         => 'genre',
                    'min_doc_count' => 5,
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_shard_min_doc_count_parameter()
    {
        $aggregation = new TermsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->shardMinDocCount(5);

        $expectedArray = [
            'genres' => [
                'terms' => [
                    'field'               => 'genre',
                    'shard_min_doc_count' => 5,
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_include_parameter()
    {
        $aggregation = new TermsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->include('.*sport.*');

        $expectedArray = [
            'genres' => [
                'terms' => [
                    'field'   => 'genre',
                    'include' => '.*sport.*',
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_exclude_parameter()
    {
        $aggregation = new TermsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->exclude('.*sport.*');

        $expectedArray = [
            'genres' => [
                'terms' => [
                    'field'   => 'genre',
                    'exclude' => '.*sport.*',
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_missing_parameter()
    {
        $aggregation = new TermsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->missing('N/A');

        $expectedArray = [
            'genres' => [
                'terms' => [
                    'field'   => 'genre',
                    'missing' => 'N/A',
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_execution_hint_parameter()
    {
        $aggregation = new TermsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->executionHint('global_ordinals');

        $expectedArray = [
            'genres' => [
                'terms' => [
                    'field'          => 'genre',
                    'execution_hint' => 'global_ordinals',
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_can_have_a_single_nested_aggregation()
    {
        $aggregation1 = new TermsAggregation();
        $aggregation1->name('genres');
        $aggregation1->field('genre');

        $aggregation2 = new TermsAggregation();
        $aggregation2->name('colors');
        $aggregation2->field('color');

        $aggregation1->aggregation($aggregation2);

        $expectedArray = [
            'genres' => [
                'terms' => [
                    'field' => 'genre',
                ],
                'aggs' => [
                    'colors' => [
                        'terms' => [
                            'field' => 'color',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation1->toArray());
    }

    /**
     * @test
     */
    public function it_can_have_multiple_nested_aggregation()
    {
        $aggregation1 = new TermsAggregation();
        $aggregation1->name('genres');
        $aggregation1->field('genre');

        $aggregation2 = new TermsAggregation();
        $aggregation2->name('colors_1');
        $aggregation2->field('color');

        $aggregation3 = new TermsAggregation();
        $aggregation3->name('colors_2');
        $aggregation3->field('color');

        $aggregation1->aggregations([$aggregation2, $aggregation3]);

        $expectedArray = [
            'genres' => [
                'terms' => [
                    'field' => 'genre',
                ],
                'aggs' => [
                    'colors_1' => [
                        'terms' => [
                            'field' => 'color',
                        ],
                    ],
                    'colors_2' => [
                        'terms' => [
                            'field' => 'color',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation1->toArray());
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_name_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The Aggregation "name" is required!');

        $aggregation = new TermsAggregation();
        $aggregation->toArray();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $aggregation = new TermsAggregation();
        $aggregation->name('genres');
        $aggregation->toArray();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_collect_mode_is_invalid_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [something] mode is not valid!');

        $aggregation = new TermsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->collectMode('something');
        $aggregation->toArray();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_execution_hint_is_invalid_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [something] hint is not valid!');

        $aggregation = new TermsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->executionHint('something');
        $aggregation->toArray();
    }
}
