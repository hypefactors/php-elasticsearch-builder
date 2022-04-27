<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Aggregation\Metrics;

use Hypefactors\ElasticBuilder\Aggregation\Metrics\TopHitsAggregation;
use Hypefactors\ElasticBuilder\Core\Sort;
use Hypefactors\ElasticBuilder\Highlight\Highlight;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;
use Hypefactors\ElasticBuilder\Core\Script;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;

class TopHitsAggregationTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $aggregation = new TopHitsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');

        $expectedArray = [
            'genres' => [
                'top_hits' => [
                    'field' => 'genre',
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_from_parameter()
    {
        $aggregation = new TopHitsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->from('foo');

        $expectedArray = [
            'genres' => [
                'top_hits' => [
                    'field' => 'genre',
                    'from'  => 'foo',
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
        $aggregation = new TopHitsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->size(5);

        $expectedArray = [
            'genres' => [
                'top_hits' => [
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
    public function it_can_add_a_single_sort()
    {
        $sort = new Sort();
        $sort->field('my-field');
        $sort->order('desc');

        $aggregation = new TopHitsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->sort($sort);

        $expected = [
            'genres' => [
                'top_hits' => [
                    'field' => 'genre',
                    'sort'  => [
                        ['my-field' => 'desc'],
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_can_add_a_multiple_sorts()
    {
        $sort1 = new Sort();
        $sort1->field('my-field1');
        $sort1->order('desc');

        $sort2 = new Sort();
        $sort2->field('my-field2');
        $sort2->order('asc');

        $aggregation = new TopHitsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->sorts([$sort1, $sort2]);

        $expected = [
            'genres' => [
                'top_hits' => [
                    'field' => 'genre',
                    'sort'  => [
                        ['my-field1' => 'desc'],
                        ['my-field2' => 'asc'],
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_can_add_track_scores()
    {
        $aggregation = new TopHitsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->trackScores(true);

        $expected = [
            'genres' => [
                'top_hits' => [
                    'field'        => 'genre',
                    'track_scores' => true,
                ],
            ],
        ];

        $this->assertSame($expected, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_can_add_version()
    {
        $aggregation = new TopHitsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->version(true);

        $expected = [
            'genres' => [
                'top_hits' => [
                    'field'   => 'genre',
                    'version' => true,
                ],
            ],
        ];

        $this->assertSame($expected, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_can_add_explain()
    {
        $aggregation = new TopHitsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->explain(true);

        $expected = [
            'genres' => [
                'top_hits' => [
                    'field'   => 'genre',
                    'explain' => true,
                ],
            ],
        ];

        $this->assertSame($expected, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_can_set_the_highlight_query_globally()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $boolQuery = new BoolQuery();
        $boolQuery->must($termQuery);
        $boolQuery->minimumShouldMatch(0);

        $highlight = new Highlight();
        $highlight->field('field-a');

        $highlight->highlightQuery($boolQuery);

        $aggregation = new TopHitsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->highlight($highlight);

        $expectedArray = [
            'genres' => [
                'top_hits' => [
                    'field'     => 'genre',
                    'highlight' => [
                        'highlight_query' => [
                            'bool' => [
                                'must' => [
                                    'term' => [
                                        'user' => 'john',
                                    ],
                                ],
                                'minimum_should_match' => 0,
                            ],
                        ],
                        'fields' => [
                            'field-a' => new stdClass(),
                        ],
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "genres": {
                    "top_hits": {
                        "field": "genre",
                        "highlight": {
                            "highlight_query": {
                                "bool": {
                                    "must": {
                                        "term": {
                                            "user": "john"
                                        }
                                    },
                                    "minimum_should_match": 0
                                }
                            },
                            "fields": {
                                "field-a": {}
                            }
                        }
                    }
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $aggregation->toArray());
        $this->assertSame($expectedJson, $aggregation->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_source_parameter()
    {
        $aggregation = new TopHitsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->source("doc['field_name'].value * params.factor");

        $expectedArray = [
            'genres' => [
                'top_hits' => [
                    'field'   => 'genre',
                    '_source' => "doc['field_name'].value * params.factor",
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_a_script()
    {
        $script = new Script();
        $script->source('script source');

        $aggregation = new TopHitsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->scriptField('my-field', $script);

        $expectedArray = [
            'genres' => [
                'top_hits' => [
                    'field'         => 'genre',
                    'script_fields' => [
                        'my-field' => [
                            'source' => 'script source',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertSame($expectedArray, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function add_docvalue_fields()
    {
        $aggregation = new TopHitsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->docValueField('my-field');

        $expected = [
            'genres' => [
                'top_hits' => [
                    'field'           => 'genre',
                    'docvalue_fields' => [
                        'my-field',
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function add_docvalue_fields_with_format()
    {
        $aggregation = new TopHitsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->docValueField('my-field', 'epoch_millis');

        $expected = [
            'genres' => [
                'top_hits' => [
                    'field'           => 'genre',
                    'docvalue_fields' => [
                        [
                            'field'  => 'my-field',
                            'format' => 'epoch_millis',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $aggregation->toArray());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_stored_fields_parameter()
    {
        $aggregation = new TopHitsAggregation();
        $aggregation->name('genres');
        $aggregation->field('genre');
        $aggregation->storedFields([
            'field1' => 'foo',
            'field2' => 'foo',
        ]);

        $expectedArray = [
            'genres' => [
                'top_hits' => [
                    'field'         => 'genre',
                    'stored_fields' => [
                        'field1' => 'foo',
                        'field2' => 'foo',
                    ],
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
        $aggregation1 = new TopHitsAggregation();
        $aggregation1->name('genres');
        $aggregation1->field('genre');

        $aggregation2 = new TopHitsAggregation();
        $aggregation2->name('colors');
        $aggregation2->field('color');

        $aggregation1->aggregation($aggregation2);

        $expectedArray = [
            'genres' => [
                'top_hits' => [
                    'field' => 'genre',
                ],
                'aggs' => [
                    'colors' => [
                        'top_hits' => [
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
        $aggregation1 = new TopHitsAggregation();
        $aggregation1->name('genres');
        $aggregation1->field('genre');

        $aggregation2 = new TopHitsAggregation();
        $aggregation2->name('colors_1');
        $aggregation2->field('color');

        $aggregation3 = new TopHitsAggregation();
        $aggregation3->name('colors_2');
        $aggregation3->field('color');

        $aggregation1->aggregations([$aggregation2, $aggregation3]);

        $expectedArray = [
            'genres' => [
                'top_hits' => [
                    'field' => 'genre',
                ],
                'aggs' => [
                    'colors_1' => [
                        'top_hits' => [
                            'field' => 'color',
                        ],
                    ],
                    'colors_2' => [
                        'top_hits' => [
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

        $aggregation = new TopHitsAggregation();
        $aggregation->toArray();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $aggregation = new TopHitsAggregation();
        $aggregation->name('genres');
        $aggregation->toArray();
    }
}
