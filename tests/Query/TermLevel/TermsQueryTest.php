<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\TermLevel\TermsQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TermsQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query_for_a_single_value()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->value('john');

        $expectedArray = [
            'terms' => [
                'user' => ['john'],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms": {
                    "user": [
                        "john"
                    ]
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_a_single_value_with_the_boost_factor_parameter()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->value('john');
        $query->boost(1.5);

        $expectedArray = [
            'terms' => [
                'user'  => ['john'],
                'boost' => 1.5,
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms": {
                    "user": [
                        "john"
                    ],
                    "boost": 1.5
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_a_single_value_with_name_parameter()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->value('john');
        $query->name('my-query-name');

        $expectedArray = [
            'terms' => [
                'user'  => ['john'],
                '_name' => 'my-query-name',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms": {
                    "user": [
                        "john"
                    ],
                    "_name": "my-query-name"
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_multiple_values()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->values(['john', 'jane']);

        $expectedArray = [
            'terms' => [
                'user' => ['john', 'jane'],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms": {
                    "user": [
                        "john",
                        "jane"
                    ]
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_multiple_values_with_the_boost_factor_parameter()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->values(['john', 'jane']);
        $query->boost(1.5);

        $expectedArray = [
            'terms' => [
                'user'  => ['john', 'jane'],
                'boost' => 1.5,
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms": {
                    "user": [
                        "john",
                        "jane"
                    ],
                    "boost": 1.5
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_multiple_values_with_the_name_parameter()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->values(['john', 'jane']);
        $query->name('my-query-name');

        $expectedArray = [
            'terms' => [
                'user'  => ['john', 'jane'],
                '_name' => 'my-query-name',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms": {
                    "user": [
                        "john",
                        "jane"
                    ],
                    "_name": "my-query-name"
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_multiple_values_and_removes_duplicated_values()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->values(['john', 'jane']);
        $query->value('john');

        $expectedArray = [
            'terms' => [
                'user' => ['john', 'jane'],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms": {
                    "user": [
                        "john",
                        "jane"
                    ]
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_the_given_terms_lookup()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->termsLookup([
            'index' => 'my_index',
            'path'  => 'color',
        ]);

        $expectedArray = [
            'terms' => [
                'user' => [
                    'index' => 'my_index',
                    'path'  => 'color',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms": {
                    "user": {
                        "index": "my_index",
                        "path": "color"
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_an_index_term_lookup()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->index('my_index');

        $expectedArray = [
            'terms' => [
                'user' => [
                    'index' => 'my_index',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms": {
                    "user": {
                        "index": "my_index"
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_an_id_term_lookup()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->id('2');

        $expectedArray = [
            'terms' => [
                'user' => [
                    'id' => '2',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms": {
                    "user": {
                        "id": "2"
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_a_path_term_lookup()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->path('color');

        $expectedArray = [
            'terms' => [
                'user' => [
                    'path' => 'color',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms": {
                    "user": {
                        "path": "color"
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_a_routing_term_lookup()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->routing('something');

        $expectedArray = [
            'terms' => [
                'user' => [
                    'routing' => 'something',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms": {
                    "user": {
                        "routing": "something"
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_ensures_the_values_are_unique_and_without_weird_indexes()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->values([
            0 => 'value1',
            1 => 'value2',
            2 => 'value2',
            3 => 'value3',
        ]);

        $expectedArray = [
            'terms' => [
                'user' => ['value1', 'value2', 'value3'],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms": {
                    "user": [
                        "value1",
                        "value2",
                        "value3"
                    ]
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new TermsQuery();
        $query->toArray();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_values_are_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "values" are required!');

        $query = new TermsQuery();
        $query->field('user');

        $query->toArray();
    }
}
