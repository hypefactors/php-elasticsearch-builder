<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Aggregation\Bucket;

use Hypefactors\ElasticBuilder\Aggregation\Bucket\TermsAggregation;
use Hypefactors\ElasticBuilder\Core\Script;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;
use InvalidArgumentException;

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

        $requestBuilder = new RequestBuilder();
        $requestBuilder->aggregation($aggregation);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'genres' => [
                'terms' => [
                    'field' => 'genre',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($aggregation->isEmpty());
        $this->assertSame($expected, $aggregation->build());
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

        $requestBuilder = new RequestBuilder();
        $requestBuilder->aggregation($aggregation);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'genres' => [
                'terms' => [
                    'field' => 'genre',
                ],
                'meta' => [
                    'foo' => 'bar',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($aggregation->isEmpty());
        $this->assertSame($expected, $aggregation->build());
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

        $requestBuilder = new RequestBuilder();
        $requestBuilder->aggregation($aggregation);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'genres' => [
                'terms' => [
                    'field'        => 'genre',
                    'collect_mode' => 'breadth_first',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($aggregation->isEmpty());
        $this->assertSame($expected, $aggregation->build());
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

        $requestBuilder = new RequestBuilder();
        $requestBuilder->aggregation($aggregation);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'genres' => [
                'terms' => [
                    'field' => 'genre',
                    'order' => [
                        ['_count' => 'asc'],
                    ],
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($aggregation->isEmpty());
        $this->assertSame($expected, $aggregation->build());
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

        $requestBuilder = new RequestBuilder();
        $requestBuilder->aggregation($aggregation);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
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

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($aggregation->isEmpty());
        $this->assertSame($expected, $aggregation->build());
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

        $requestBuilder = new RequestBuilder();
        $requestBuilder->aggregation($aggregation);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'genres' => [
                'terms' => [
                    'field' => 'genre',
                    'size'  => 5,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($aggregation->isEmpty());
        $this->assertSame($expected, $aggregation->build());
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

        $requestBuilder = new RequestBuilder();
        $requestBuilder->aggregation($aggregation);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'genres' => [
                'terms' => [
                    'field'      => 'genre',
                    'shard_size' => 5,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($aggregation->isEmpty());
        $this->assertSame($expected, $aggregation->build());
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

        $requestBuilder = new RequestBuilder();
        $requestBuilder->aggregation($aggregation);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'genres' => [
                'terms' => [
                    'field'                     => 'genre',
                    'show_term_doc_count_error' => true,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($aggregation->isEmpty());
        $this->assertSame($expected, $aggregation->build());
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

        $requestBuilder = new RequestBuilder();
        $requestBuilder->aggregation($aggregation);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'genres' => [
                'terms' => [
                    'field'         => 'genre',
                    'min_doc_count' => 5,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($aggregation->isEmpty());
        $this->assertSame($expected, $aggregation->build());
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

        $requestBuilder = new RequestBuilder();
        $requestBuilder->aggregation($aggregation);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'genres' => [
                'terms' => [
                    'field'               => 'genre',
                    'shard_min_doc_count' => 5,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($aggregation->isEmpty());
        $this->assertSame($expected, $aggregation->build());
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

        $requestBuilder = new RequestBuilder();
        $requestBuilder->aggregation($aggregation);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'genres' => [
                'terms' => [
                    'field'   => 'genre',
                    'include' => '.*sport.*',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($aggregation->isEmpty());
        $this->assertSame($expected, $aggregation->build());
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

        $requestBuilder = new RequestBuilder();
        $requestBuilder->aggregation($aggregation);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'genres' => [
                'terms' => [
                    'field'   => 'genre',
                    'exclude' => '.*sport.*',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($aggregation->isEmpty());
        $this->assertSame($expected, $aggregation->build());
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

        $requestBuilder = new RequestBuilder();
        $requestBuilder->aggregation($aggregation);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'genres' => [
                'terms' => [
                    'field'   => 'genre',
                    'missing' => 'N/A',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($aggregation->isEmpty());
        $this->assertSame($expected, $aggregation->build());
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

        $requestBuilder = new RequestBuilder();
        $requestBuilder->aggregation($aggregation);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'genres' => [
                'terms' => [
                    'field'          => 'genre',
                    'execution_hint' => 'global_ordinals',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($aggregation->isEmpty());
        $this->assertSame($expected, $aggregation->build());
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

        $requestBuilder = (new RequestBuilder())
            ->aggregation($aggregation1)
        ;

        $response = $this->client->search($requestBuilder->build());

        $expected = [
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

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($aggregation1->isEmpty());
        $this->assertSame($expected, $aggregation1->build());
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

        $aggregation1->aggregation($aggregation2);
        $aggregation1->aggregation($aggregation3);

        $requestBuilder = (new RequestBuilder())
            ->aggregation($aggregation1)
        ;

        $response = $this->client->search($requestBuilder->build());

        $expected = [
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

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($aggregation1->isEmpty());
        $this->assertSame($expected, $aggregation1->build());
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_name_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The Aggregation "name" is required!');

        $aggregation = new TermsAggregation();
        $aggregation->build();
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
        $aggregation->build();
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
        $aggregation->build();
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
        $aggregation->build();
    }
}
