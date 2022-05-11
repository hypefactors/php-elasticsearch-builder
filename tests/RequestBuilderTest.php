<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests;

use Hypefactors\ElasticBuilder\Aggregation\Bucket\TermsAggregation;
use Hypefactors\ElasticBuilder\Core\Collapse;
use Hypefactors\ElasticBuilder\Core\CollapseInterface;
use Hypefactors\ElasticBuilder\Core\Highlight;
use Hypefactors\ElasticBuilder\Core\HighlightInterface;
use Hypefactors\ElasticBuilder\Core\Script;
use Hypefactors\ElasticBuilder\Core\Sort;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQueryInterface;
use Hypefactors\ElasticBuilder\QueryBuilder;
use Hypefactors\ElasticBuilder\RequestBuilder;
use PHPUnit\Framework\TestCase;
use stdClass;

class RequestBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function set_a_single_option()
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilder->option('index', 'ci-index');

        $expected = [
            'index' => 'ci-index',
        ];

        $this->assertSame($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function set_multiple_options()
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilder->options([
            'option1' => 'value1',
            'option2' => 'value2',
        ]);

        $expected = [
            'option1' => 'value1',
            'option2' => 'value2',
        ];

        $this->assertSame($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function set_index()
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');

        $expected = [
            'index' => 'ci-index',
        ];

        $this->assertSame($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function add_docvalue_fields()
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilder->docValueField('name');

        $expected = [
            'body' => [
                'docvalue_fields' => [
                    'name',
                ],
            ],
        ];

        $this->assertSame($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function add_docvalue_fields_with_format()
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilder->docValueField('name', 'epoch_millis');

        $expected = [
            'body' => [
                'docvalue_fields' => [
                    [
                        'field'  => 'name',
                        'format' => 'epoch_millis',
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function add_explain()
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilder->explain(true);

        $expected = [
            'body' => [
                'explain' => true,
            ],
        ];

        $this->assertSame($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function add_collapse_using_a_class_instance()
    {
        $collapse = new Collapse();
        $collapse->field('name');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->collapse($collapse);

        $expected = [
            'body' => [
                'collapse' => [
                    'field' => 'name',
                ],
            ],
        ];

        $this->assertSame($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function add_collapse_using_a_closure()
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilder->collapse(function (CollapseInterface $collapse) {
            $collapse->field('name');
        });

        $expected = [
            'body' => [
                'collapse' => [
                    'field' => 'name',
                ],
            ],
        ];

        $this->assertSame($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function add_from()
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilder->from('id-123');

        $expected = [
            'body' => [
                'from' => 'id-123',
            ],
        ];

        $this->assertSame($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function add_size()
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilder->size(20);

        $expected = [
            'body' => [
                'size' => 20,
            ],
        ];

        $this->assertSame($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function add_highlight_using_a_class_instance()
    {
        $highlight = new Highlight();
        $highlight->fields([
            'field-a',
            'field-b' => [],
            'field-c',
            'field-d' => (new Highlight())->fragmentSize(2),
        ]);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

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

        $this->assertEquals($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function add_highlight_using_a_closure()
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight(function (HighlightInterface $highlight) {
            $highlight->fields([
                'field-a',
                'field-b' => [],
                'field-c',
                'field-d' => (new Highlight())->fragmentSize(2),
            ]);
        });

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

        $this->assertEquals($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function add_min_score()
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilder->minScore(20);

        $expected = [
            'body' => [
                'min_score' => 20,
            ],
        ];

        $this->assertSame($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function add_script_field()
    {
        $script = new Script();
        $script->source('script source');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->scriptField('name', $script);

        $expected = [
            'body' => [
                'script_fields' => [
                    'name' => [
                        'source' => 'script source',
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function add_search_after()
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilder->searchAfter([123, 456]);

        $expected = [
            'body' => [
                'search_after' => [123, 456],
            ],
        ];

        $this->assertSame($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function add_timeout()
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilder->timeout(500);

        $expected = [
            'body' => [
                'timeout' => 500,
            ],
        ];

        $this->assertSame($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function add_search_type()
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilder->searchType('dfs_query_then_fetch');

        $expected = [
            'body' => [
                'search_type' => 'dfs_query_then_fetch',
            ],
        ];

        $this->assertSame($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function add_terminate_after()
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilder->terminateAfter(40);

        $expected = [
            'body' => [
                'terminate_after' => 40,
            ],
        ];

        $this->assertSame($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function add_sort()
    {
        $sort = new Sort();
        $sort->field('name');
        $sort->order('desc');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->sort($sort);

        $expected = [
            'body' => [
                'sort' => [
                    ['name' => 'desc'],
                ],
            ],
        ];

        $this->assertSame($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function add_multiple_sorts()
    {
        $sort1 = new Sort();
        $sort1->field('name-1');
        $sort1->order('desc');

        $sort2 = new Sort();
        $sort2->field('name-2');
        $sort2->order('desc');
        $sort2->mode('avg');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->sort($sort1);
        $requestBuilder->sort($sort2);

        $expected = [
            'body' => [
                'sort' => [
                    ['name-1' => 'desc'],
                    [
                        'name-2' => [
                            'order' => 'desc',
                            'mode'  => 'avg',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function add_source()
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilder->source([
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

        $this->assertSame($expected, $requestBuilder->build());
    }

    /**
     * @test
     */
    public function add_query()
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQuery $query) {
            $query->filter(function (FilterQuery $query) {
                $query->term(function (TermQueryInterface $query) {
                    $query->field('user')->value('John');
                });
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $expected = [
            'body' => [
                'query' => [
                    'bool' => [
                        'filter' => [
                            'term' => [
                                'user' => 'John',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $requestBuilder->build());
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

        $requestBuilder = new RequestBuilder();
        $requestBuilder->aggregation($aggregation1);
        $requestBuilder->aggregation($aggregation2);

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

        $this->assertSame($expected, $requestBuilder->build());
    }
}
