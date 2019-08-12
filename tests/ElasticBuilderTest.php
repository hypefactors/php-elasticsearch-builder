<?php

namespace Hypefactors\ElasticBuilder\Tests;

use stdClass;
use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Core\Sort;
use Hypefactors\ElasticBuilder\Core\Script;
use Hypefactors\ElasticBuilder\Core\Highlight;
use Hypefactors\ElasticBuilder\ElasticBuilder;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;
use Hypefactors\ElasticBuilder\Aggregation\Bucketing\TermsAggregation;

class ElasticBuilderTest extends TestCase
{
    /** @test */
    public function add_docvalue_fields()
    {
        $builder = new ElasticBuilder();
        $builder->docValueField('my-field');

        $expected = [
            'docvalue_fields' => [
                'my-field',
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /** @test */
    public function add_docvalue_fields_with_format()
    {
        $builder = new ElasticBuilder();
        $builder->docValueField('my-field', 'epoch_millis');

        $expected = [
            'docvalue_fields' => [
                [
                    'field'  => 'my-field',
                    'format' => 'epoch_millis',
                ],
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /** @test */
    public function add_explain()
    {
        $builder = new ElasticBuilder();
        $builder->explain(true);

        $expected = [
            'explain' => true,
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /** @test */
    public function add_collapse()
    {
        $builder = new ElasticBuilder();
        $builder->collapse('my-field');

        $expected = [
            'collapse' => [
                'field' => 'my-field',
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /** @test */
    public function add_from()
    {
        $builder = new ElasticBuilder();
        $builder->from('id-123');

        $expected = [
            'from' => 'id-123',
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /** @test */
    public function add_size()
    {
        $builder = new ElasticBuilder();
        $builder->size(20);

        $expected = [
            'size' => 20,
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /** @test */
    public function add_highlight()
    {
        $highlight = new Highlight();
        $highlight->fields([
            'field-a',
            'field-b',
        ]);

        $builder = new ElasticBuilder();
        $builder->highlight($highlight);

        $expected = [
            'highlight' => [
                'fields' => [
                    'field-a' => new stdClass(),
                    'field-b' => new stdClass(),
                ],
            ],
        ];

        $this->assertEquals($expected, $builder->toArray());
    }

    /** @test */
    public function add_min_score()
    {
        $builder = new ElasticBuilder();
        $builder->minScore(20);

        $expected = [
            'min_score' => 20,
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /** @test */
    public function add_script_field()
    {
        $script = new Script();
        $script->source('script source');

        $builder = new ElasticBuilder();
        $builder->scriptField('my-field', $script);

        $expected = [
            'script_fields' => [
                'my-field' => [
                    'source' => 'script source',
                ],
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /** @test */
    public function add_search_after()
    {
        $builder = new ElasticBuilder();
        $builder->searchAfter([123, 456]);

        $expected = [
            'search_after' => [123, 456],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /** @test */
    public function add_timeout()
    {
        $builder = new ElasticBuilder();
        $builder->timeout(500);

        $expected = [
            'timeout' => 500,
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /** @test */
    public function add_search_type()
    {
        $builder = new ElasticBuilder();
        $builder->searchType('dfs_query_then_fetch');

        $expected = [
            'search_type' => 'dfs_query_then_fetch',
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /** @test */
    public function add_terminate_after()
    {
        $builder = new ElasticBuilder();
        $builder->terminateAfter(40);

        $expected = [
            'terminate_after' => 40,
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /** @test */
    public function add_sort()
    {
        $sort = new Sort();
        $sort->field('my-field');
        $sort->order('desc');

        $builder = new ElasticBuilder();
        $builder->sort($sort);

        $expected = [
            'sort' => [
                [
                    'my-field' => 'desc',
                ],
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /** @test */
    public function add_multiple_sorts()
    {
        $sort1 = new Sort();
        $sort1->field('my-field');
        $sort1->order('desc');

        $sort2 = new Sort();
        $sort2->field('my-field');
        $sort2->order('desc');
        $sort2->mode('avg');

        $builder = new ElasticBuilder();
        $builder->sorts([$sort1, $sort2]);

        $expected = [
            'sort' => [
                [
                    'my-field' => 'desc',
                ],
                [
                    'my-field' => [
                        'order' => 'desc',
                        'mode'  => 'avg',
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /** @test */
    public function add_source()
    {
        $builder = new ElasticBuilder();
        $builder->source([
            'field-1',
            'field-2',
        ]);

        $expected = [
            'source' => [
                'field-1',
                'field-2',
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /** @test */
    public function add_query()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $query = new BoolQuery();
        $query->filter($termQuery);

        $builder = new ElasticBuilder();
        $builder->query($query);
        $builder->query($termQuery);

        $expected = [
            'query' => [
                'bool' => [
                    'filter' => [
                        'term' => [
                            'user' => 'john',
                        ],
                    ],
                ],
                'term' => [
                    'user' => 'john',
                ]
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /** @test */
    public function add_aggregation()
    {
        $aggregation1 = new TermsAggregation();
        $aggregation1->name('genres');
        $aggregation1->field('genre');

        $aggregation2 = new TermsAggregation();
        $aggregation2->name('colors');
        $aggregation2->field('my-color');

        $builder = new ElasticBuilder();
        $builder->aggregation($aggregation1);
        $builder->aggregation($aggregation2);

        $expected = [
            'aggs' => [
                'genres' => [
                    'terms' => [
                        'field' => 'genre',
                    ],
                ],
                'colors' => [
                    'terms' => [
                        'field' => 'my-color',
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }
}
