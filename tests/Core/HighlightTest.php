<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Core;

use Hypefactors\ElasticBuilder\Core\Highlight;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\ExistsQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;

class HighlightTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_set_the_boundary_chars_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->boundaryChars('.,!?');

        $expectedArray = [
            'boundary_chars' => '.,!?',
            'fields'         => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "boundary_chars": ".,!?",
                "fields": {
                    "field-a": {},
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_boundary_chars_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->boundaryChars('.,!?', 'field-a');

        $expectedArray = [
            'fields' => [
                'field-a' => [
                    'boundary_chars' => '.,!?',
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fields": {
                    "field-a": {
                        "boundary_chars": ".,!?"
                    },
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_boundary_max_scan_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->boundaryMaxScan(5);

        $expectedArray = [
            'boundary_max_scan' => 5,
            'fields'            => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "boundary_max_scan": 5,
                "fields": {
                    "field-a": {},
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_boundary_max_scan_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->boundaryMaxScan(5, 'field-a');

        $expectedArray = [
            'fields' => [
                'field-a' => [
                    'boundary_max_scan' => 5,
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fields": {
                    "field-a": {
                        "boundary_max_scan": 5
                    },
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_boundary_scanner_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->boundaryScanner('chars');

        $expectedArray = [
            'boundary_scanner' => 'chars',
            'fields'           => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "boundary_scanner": "chars",
                "fields": {
                    "field-a": {},
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_boundary_scanner_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->boundaryScanner('chars', 'field-a');

        $expectedArray = [
            'fields' => [
                'field-a' => [
                    'boundary_scanner' => 'chars',
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fields": {
                    "field-a": {
                        "boundary_scanner": "chars"
                    },
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_boundary_scanner_locale_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->boundaryScannerLocale('en-US');

        $expectedArray = [
            'boundary_scanner_locale' => 'en-US',
            'fields'                  => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "boundary_scanner_locale": "en-US",
                "fields": {
                    "field-a": {},
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_boundary_scanner_locale_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->boundaryScannerLocale('en-US', 'field-a');

        $expectedArray = [
            'fields' => [
                'field-a' => [
                    'boundary_scanner_locale' => 'en-US',
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fields": {
                    "field-a": {
                        "boundary_scanner_locale": "en-US"
                    },
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_encoder()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->encoder('html');

        $expectedArray = [
            'encoder' => 'html',
            'fields'  => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "encoder": "html",
                "fields": {
                    "field-a": {},
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_a_single_field()
    {
        $highlight = new Highlight();
        $highlight->field('my-field');

        $expectedArray = [
            'fields' => [
                'my-field' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fields": {
                    "my-field": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_multiple_fields()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');

        $expectedArray = [
            'fields' => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fields": {
                    "field-a": {},
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_multiple_fields_from_an_array()
    {
        $highlight = new Highlight();
        $highlight->fields([
            'field-a' => (new Highlight())->numberOfFragments(1),
            'field-b',
        ]);

        $expectedArray = [
            'fields' => [
                'field-a' => [
                    'number_of_fragments' => 1,
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fields": {
                    "field-a": {
                        "number_of_fragments": 1
                    },
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_force_source_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->forceSource(true);

        $expectedArray = [
            'force_source' => true,
            'fields'       => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "force_source": true,
                "fields": {
                    "field-a": {},
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_force_source_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->forceSource(true, 'field-a');

        $expectedArray = [
            'fields' => [
                'field-a' => [
                    'force_source' => true,
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fields": {
                    "field-a": {
                        "force_source": true
                    },
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_fragmenter_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->fragmenter('simple');

        $expectedArray = [
            'fragmenter' => 'simple',
            'fields'     => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fragmenter": "simple",
                "fields": {
                    "field-a": {},
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_fragmenter_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->fragmenter('simple', 'field-a');

        $expectedArray = [
            'fields' => [
                'field-a' => [
                    'fragmenter' => 'simple',
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fields": {
                    "field-a": {
                        "fragmenter": "simple"
                    },
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_fragment_offset_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->fragmentOffset(1);

        $expectedArray = [
            'type'            => 'fvh',
            'fragment_offset' => 1,
            'fields'          => [
                'field-a' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "type": "fvh",
                "fragment_offset": 1,
                "fields": {
                    "field-a": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_fragment_offset_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->fragmentOffset(1, 'field-a');

        $expectedArray = [
            'fields' => [
                'field-a' => [
                    'type'            => 'fvh',
                    'fragment_offset' => 1,
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fields": {
                    "field-a": {
                        "type": "fvh",
                        "fragment_offset": 1
                    },
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_fragment_size_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->fragmentSize(1);

        $expectedArray = [
            'fragment_size' => 1,
            'fields'        => [
                'field-a' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fragment_size": 1,
                "fields": {
                    "field-a": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_fragment_size_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->fragmentSize(1, 'field-a');

        $expectedArray = [
            'fields' => [
                'field-a' => [
                    'fragment_size' => 1,
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fields": {
                    "field-a": {
                        "fragment_size": 1
                    },
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_highlight_query_globally()
    {
        $existsQuery = new ExistsQuery();
        $existsQuery->field('user');

        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $boolQuery = new BoolQuery();
        $boolQuery->must($termQuery);
        $boolQuery->should($existsQuery);
        $boolQuery->minimumShouldMatch(0);

        $highlight = new Highlight();
        $highlight->field('field-a');

        $highlight->highlightQuery($boolQuery);

        $expectedArray = [
            'highlight_query' => [
                'bool' => [
                    'must' => [
                        'term' => [
                            'user' => 'john',
                        ],
                    ],
                    'should' => [
                        'exists' => [
                            'field' => 'user',
                        ],
                    ],
                    'minimum_should_match' => 0,
                ],
            ],
            'fields' => [
                'field-a' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "highlight_query": {
                    "bool": {
                        "must": {
                            "term": {
                                "user": "john"
                            }
                        },
                        "should": {
                            "exists": {
                                "field": "user"
                            }
                        },
                        "minimum_should_match": 0
                    }
                },
                "fields": {
                    "field-a": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_highlight_query_on_a_field()
    {
        $existsQuery = new ExistsQuery();
        $existsQuery->field('user');

        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $boolQuery = new BoolQuery();
        $boolQuery->must($termQuery);
        $boolQuery->should($existsQuery);
        $boolQuery->minimumShouldMatch(0);

        $highlight = new Highlight();
        $highlight->field('field-a');

        $highlight->highlightQuery($boolQuery, 'field-a');

        $expectedArray = [
            'fields' => [
                'field-a' => [
                    'highlight_query' => [
                        'bool' => [
                            'must' => [
                                'term' => [
                                    'user' => 'john',
                                ],
                            ],
                            'should' => [
                                'exists' => [
                                    'field' => 'user',
                                ],
                            ],
                            'minimum_should_match' => 0,
                        ],
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fields": {
                    "field-a": {
                        "highlight_query": {
                            "bool": {
                                "must": {
                                    "term": {
                                        "user": "john"
                                    }
                                },
                                "should": {
                                    "exists": {
                                        "field": "user"
                                    }
                                },
                                "minimum_should_match": 0
                            }
                        }
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_matched_fields_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->matchedFields(['something'], 'field-a');

        $expectedArray = [
            'fields' => [
                'field-a' => [
                    'type'           => 'fvh',
                    'matched_fields' => [
                        'something',
                    ],
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fields": {
                    "field-a": {
                        "type": "fvh",
                        "matched_fields": [
                            "something"
                        ]
                    },
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_no_match_size_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->noMatchSize(1, 'field-a');

        $expectedArray = [
            'fields' => [
                'field-a' => [
                    'no_match_size' => 1,
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fields": {
                    "field-a": {
                        "no_match_size": 1
                    },
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_number_of_fragments_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->numberOfFragments(1);

        $expectedArray = [
            'number_of_fragments' => 1,
            'fields'              => [
                'field-a' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "number_of_fragments": 1,
                "fields": {
                    "field-a": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_number_of_fragments_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->numberOfFragments(1, 'field-a');

        $expectedArray = [
            'fields' => [
                'field-a' => [
                    'number_of_fragments' => 1,
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fields": {
                    "field-a": {
                        "number_of_fragments": 1
                    },
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_score_order_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->scoreOrder();

        $expectedArray = [
            'order'  => 'score',
            'fields' => [
                'field-a' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "order": "score",
                "fields": {
                    "field-a": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_score_order_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->scoreOrder('field-a');

        $expectedArray = [
            'fields' => [
                'field-a' => [
                    'order' => 'score',
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fields": {
                    "field-a": {
                        "order": "score"
                    },
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_phrase_limit()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->phraseLimit(10);

        $expectedArray = [
            'phrase_limit' => 10,
            'fields'       => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "phrase_limit": 10,
                "fields": {
                    "field-a": {},
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_pre_tags_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->preTags('<em>');

        $expectedArray = [
            'pre_tags' => [
                '<em>',
            ],
            'fields' => [
                'field-a' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "pre_tags": [
                    "<em>"
                ],
                "fields": {
                    "field-a": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_pre_tags_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->preTags('<em>', 'field-a');

        $expectedArray = [
            'fields' => [
                'field-a' => [
                    'pre_tags' => [
                        '<em>',
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fields": {
                    "field-a": {
                        "pre_tags": [
                            "<em>"
                        ]
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_post_tags_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->postTags('</em>');

        $expectedArray = [
            'post_tags' => [
                '</em>',
            ],
            'fields' => [
                'field-a' => new stdClass(),
            ],
        ];

        $expectedJson = <<<JSON
            {
                "post_tags": [
                    "<\/em>"
                ],
                "fields": {
                    "field-a": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_post_tags_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->postTags('</em>', 'field-a');

        $expectedArray = [
            'fields' => [
                'field-a' => [
                    'post_tags' => [
                        '</em>',
                    ],
                ],
            ],
        ];

        $expectedJson = <<<JSON
            {
                "fields": {
                    "field-a": {
                        "post_tags": [
                            "<\/em>"
                        ]
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_require_field_match_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->requireFieldMatch(true);

        $expectedArray = [
            'require_field_match' => true,
            'fields'              => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "require_field_match": true,
                "fields": {
                    "field-a": {},
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_require_field_match_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->requireFieldMatch(true, 'field-a');

        $expectedArray = [
            'fields' => [
                'field-a' => [
                    'require_field_match' => true,
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fields": {
                    "field-a": {
                        "require_field_match": true
                    },
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_tags_schema_as_styled()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->tagsSchema();

        $expectedArray = [
            'tags_schema' => 'styled',
            'fields'      => [
                'field-a' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "tags_schema": "styled",
                "fields": {
                    "field-a": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_type_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->type('plain');

        $expectedArray = [
            'type'   => 'plain',
            'fields' => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "type": "plain",
                "fields": {
                    "field-a": {},
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_type_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->type('plain', 'field-a');

        $expectedArray = [
            'fields' => [
                'field-a' => [
                    'type' => 'plain',
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fields": {
                    "field-a": {
                        "type": "plain"
                    },
                    "field-b": {}
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $highlight->toArray());
        $this->assertSame($expectedJson, $highlight->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_when_setting_an_invalid_boundary_scanner()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [foo] boundary scanner is invalid!');

        $highlight = new Highlight();
        $highlight->boundaryScanner('foo');
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_when_setting_an_invalid_encoder()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [foo] encoder is invalid!');

        $highlight = new Highlight();
        $highlight->encoder('foo');
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_when_setting_an_invalid_type()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [foo] type is invalid!');

        $highlight = new Highlight();
        $highlight->type('foo');
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_when_setting_an_invalid_fragmenter()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [foo] fragmenter is invalid!');

        $highlight = new Highlight();
        $highlight->fragmenter('foo');
    }
}
