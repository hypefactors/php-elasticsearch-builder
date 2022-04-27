<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests;

use Hypefactors\ElasticBuilder\Aggregation\Bucketing\TermsAggregation;
use Hypefactors\ElasticBuilder\Core\Script;
use Hypefactors\ElasticBuilder\Core\Sort;
use Hypefactors\ElasticBuilder\ElasticBuilder;
use Hypefactors\ElasticBuilder\Highlight\Highlight;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ElasticBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function add_docvalue_fields()
    {
        $builder = new ElasticBuilder();
        $builder->docValueField('my-field');

        $expected = [
            'body' => [
                'docvalue_fields' => [
                    'my-field',
                ],
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /**
     * @test
     */
    public function add_docvalue_fields_with_format()
    {
        $builder = new ElasticBuilder();
        $builder->docValueField('my-field', 'epoch_millis');

        $expected = [
            'body' => [
                'docvalue_fields' => [
                    [
                        'field'  => 'my-field',
                        'format' => 'epoch_millis',
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /**
     * @test
     */
    public function add_explain()
    {
        $builder = new ElasticBuilder();
        $builder->explain(true);

        $expected = [
            'body' => [
                'explain' => true,
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /**
     * @test
     */
    public function add_collapse()
    {
        $builder = new ElasticBuilder();
        $builder->collapse('my-field');

        $expected = [
            'body' => [
                'collapse' => [
                    'field' => 'my-field',
                ],
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /**
     * @test
     */
    public function add_from()
    {
        $builder = new ElasticBuilder();
        $builder->from('id-123');

        $expected = [
            'body' => [
                'from' => 'id-123',
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /**
     * @test
     */
    public function add_size()
    {
        $builder = new ElasticBuilder();
        $builder->size(20);

        $expected = [
            'body' => [
                'size' => 20,
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /**
     * @test
     */
    public function add_highlight()
    {
        $highlight = new Highlight();
        $highlight->fields([
            'field-a',
            'field-b' => [],
            'field-c',
            'field-d' => (new Highlight())->fragmentSize(2),
        ]);

        $builder = new ElasticBuilder();
        $builder->highlight($highlight);

        $expected = [
            'body' => [
                'highlight' => [
                    'fields' => [
                        'field-a' => new stdClass(),
                        'field-b' => new stdClass(),
                        'field-c' => new stdClass(),
                        'field-d' => [
                            'fragment_size' => 2,
                        ],
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $builder->toArray());
    }

    /**
     * @test
     */
    public function add_min_score()
    {
        $builder = new ElasticBuilder();
        $builder->minScore(20);

        $expected = [
            'body' => [
                'min_score' => 20,
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /**
     * @test
     */
    public function add_script_field()
    {
        $script = new Script();
        $script->source('script source');

        $builder = new ElasticBuilder();
        $builder->scriptField('my-field', $script);

        $expected = [
            'body' => [
                'script_fields' => [
                    'my-field' => [
                        'source' => 'script source',
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /**
     * @test
     */
    public function add_search_after()
    {
        $builder = new ElasticBuilder();
        $builder->searchAfter([123, 456]);

        $expected = [
            'body' => [
                'search_after' => [123, 456],
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /**
     * @test
     */
    public function add_timeout()
    {
        $builder = new ElasticBuilder();
        $builder->timeout(500);

        $expected = [
            'body' => [
                'timeout' => 500,
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /**
     * @test
     */
    public function add_search_type()
    {
        $builder = new ElasticBuilder();
        $builder->searchType('dfs_query_then_fetch');

        $expected = [
            'body' => [
                'search_type' => 'dfs_query_then_fetch',
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /**
     * @test
     */
    public function add_terminate_after()
    {
        $builder = new ElasticBuilder();
        $builder->terminateAfter(40);

        $expected = [
            'body' => [
                'terminate_after' => 40,
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /**
     * @test
     */
    public function add_sort()
    {
        $sort = new Sort();
        $sort->field('my-field');
        $sort->order('desc');

        $builder = new ElasticBuilder();
        $builder->sort($sort);

        $expected = [
            'body' => [
                'sort' => [
                    ['my-field' => 'desc'],
                ],
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /**
     * @test
     */
    public function add_multiple_sorts()
    {
        $sort1 = new Sort();
        $sort1->field('my-field-1');
        $sort1->order('desc');

        $sort2 = new Sort();
        $sort2->field('my-field-2');
        $sort2->order('desc');
        $sort2->mode('avg');

        $builder = new ElasticBuilder();
        $builder->sorts([$sort1, $sort2]);

        $expected = [
            'body' => [
                'sort' => [
                    ['my-field-1' => 'desc'],
                    [
                        'my-field-2' => [
                            'order' => 'desc',
                            'mode'  => 'avg',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /**
     * @test
     */
    public function add_source()
    {
        $builder = new ElasticBuilder();
        $builder->source([
            'field-1',
            'field-2',
        ]);

        $expected = [
            'body' => [
                '_source' => [
                    'field-1',
                    'field-2',
                ],
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /**
     * @test
     */
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
            'body' => [
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
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }

    /**
     * @test
     */
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
            'body' => [
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
            ],
        ];

        $this->assertSame($expected, $builder->toArray());
    }
}
