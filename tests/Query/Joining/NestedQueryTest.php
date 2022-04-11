<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Joining;

use Hypefactors\ElasticBuilder\Query\Joining\NestedQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermsQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class NestedQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $termQuery = new TermsQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $query = new NestedQuery();
        $query->path('some-path');
        $query->query($termQuery);

        $expectedArray = [
            'nested' => [
                'path'  => 'some-path',
                'query' => [
                    'terms' => [
                        'user' => ['john'],
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "nested": {
                    "path": "some-path",
                    "query": {
                        "terms": {
                            "user": [
                                "john"
                            ]
                        }
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
    public function it_builds_the_query_with_the_score_mode_parameter()
    {
        $termQuery = new TermsQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $query = new NestedQuery();
        $query->path('some-path');
        $query->query($termQuery);
        $query->scoreMode('avg');

        $expectedArray = [
            'nested' => [
                'path'  => 'some-path',
                'query' => [
                    'terms' => [
                        'user' => ['john'],
                    ],
                ],
                'score_mode' => 'avg',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "nested": {
                    "path": "some-path",
                    "query": {
                        "terms": {
                            "user": [
                                "john"
                            ]
                        }
                    },
                    "score_mode": "avg"
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_ignore_unmapped_parameter()
    {
        $termQuery = new TermsQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $query = new NestedQuery();
        $query->path('some-path');
        $query->query($termQuery);
        $query->ignoreUnmapped(true);

        $expectedArray = [
            'nested' => [
                'path'  => 'some-path',
                'query' => [
                    'terms' => [
                        'user' => ['john'],
                    ],
                ],
                'ignore_unmapped' => true,
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "nested": {
                    "path": "some-path",
                    "query": {
                        "terms": {
                            "user": [
                                "john"
                            ]
                        }
                    },
                    "ignore_unmapped": true
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_when_passing_an_invalid_score_mode()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [foo] score mode is invalid.');

        $termQuery = new TermsQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $query = new NestedQuery();
        $query->path('some-path');
        $query->query($termQuery);
        $query->scoreMode('foo');
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_path_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "path" is required!');

        $query = new NestedQuery();
        $query->toArray();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_query_are_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "query" is required!');

        $query = new NestedQuery();
        $query->path('some-path');

        $query->toArray();
    }
}
