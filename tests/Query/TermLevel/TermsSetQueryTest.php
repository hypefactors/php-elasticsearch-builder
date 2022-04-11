<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\TermLevel\TermsSetQuery;
use PHPUnit\Framework\TestCase;

class TermsSetQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query_for_a_single_term()
    {
        $query = new TermsSetQuery();
        $query->field('my_field');
        $query->term('a-value');

        $expectedArray = [
            'terms_set' => [
                'my_field' => [
                    'terms' => ['a-value'],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms_set": {
                    "my_field": {
                        "terms": [
                            "a-value"
                        ]
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
    public function it_builds_the_query_for_a_single_term_with_the_boost_factor_parameter()
    {
        $query = new TermsSetQuery();
        $query->field('my_field');
        $query->term('a-value');
        $query->boost(1.5);

        $expectedArray = [
            'terms_set' => [
                'my_field' => [
                    'terms' => ['a-value'],
                    'boost' => 1.5,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms_set": {
                    "my_field": {
                        "terms": [
                            "a-value"
                        ],
                        "boost": 1.5
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
    public function it_builds_the_query_for_a_single_term_with_the_name_parameter()
    {
        $query = new TermsSetQuery();
        $query->field('my_field');
        $query->term('a-value');
        $query->name('my-query-name');

        $expectedArray = [
            'terms_set' => [
                'my_field' => [
                    'terms' => ['a-value'],
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms_set": {
                    "my_field": {
                        "terms": [
                            "a-value"
                        ],
                        "_name": "my-query-name"
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
    public function it_builds_the_query_for_a_single_term_with_the_minimum_should_match_field_1()
    {
        $query = new TermsSetQuery();
        $query->field('my_field');
        $query->term('value-a');
        $query->minimumShouldMatchField('required_matches');

        $expectedArray = [
            'terms_set' => [
                'my_field' => [
                    'terms'                      => ['value-a'],
                    'minimum_should_match_field' => 'required_matches',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms_set": {
                    "my_field": {
                        "terms": [
                            "value-a"
                        ],
                        "minimum_should_match_field": "required_matches"
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
    public function it_builds_the_query_for_a_single_term_with_the_minimum_should_match_field_2()
    {
        $query = new TermsSetQuery();
        $query->field('my_field');
        $query->term('value-a');
        $query->minimumShouldMatchScript([
            'source' => "Math.min(params.num_terms, doc['required_matches'].value)",
        ]);

        $expectedArray = [
            'terms_set' => [
                'my_field' => [
                    'terms'                       => ['value-a'],
                    'minimum_should_match_script' => [
                        'source' => "Math.min(params.num_terms, doc['required_matches'].value)",
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms_set": {
                    "my_field": {
                        "terms": [
                            "value-a"
                        ],
                        "minimum_should_match_script": {
                            "source": "Math.min(params.num_terms, doc['required_matches'].value)"
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
    public function it_builds_the_query_for_multiple_terms()
    {
        $query = new TermsSetQuery();
        $query->field('my_field');
        $query->terms(['value-a', 'value-b']);

        $expectedArray = [
            'terms_set' => [
                'my_field' => [
                    'terms' => ['value-a', 'value-b'],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms_set": {
                    "my_field": {
                        "terms": [
                            "value-a",
                            "value-b"
                        ]
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
    public function it_builds_the_query_for_multiple_terms_with_the_boost_factor_parameter()
    {
        $query = new TermsSetQuery();
        $query->field('my_field');
        $query->terms(['value-a', 'value-b']);
        $query->boost(1.5);

        $expectedArray = [
            'terms_set' => [
                'my_field' => [
                    'terms' => ['value-a', 'value-b'],
                    'boost' => 1.5,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms_set": {
                    "my_field": {
                        "terms": [
                            "value-a",
                            "value-b"
                        ],
                        "boost": 1.5
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
    public function it_builds_the_query_for_multiple_terms_with_the_name_parameter()
    {
        $query = new TermsSetQuery();
        $query->field('my_field');
        $query->terms(['value-a', 'value-b']);
        $query->name('my-query-name');

        $expectedArray = [
            'terms_set' => [
                'my_field' => [
                    'terms' => ['value-a', 'value-b'],
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms_set": {
                    "my_field": {
                        "terms": [
                            "value-a",
                            "value-b"
                        ],
                        "_name": "my-query-name"
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
    public function it_builds_the_query_for_multiple_terms_with_the_minimum_should_match_field_1()
    {
        $query = new TermsSetQuery();
        $query->field('my_field');
        $query->terms(['value-a', 'value-b']);
        $query->minimumShouldMatchField('required_matches');

        $expectedArray = [
            'terms_set' => [
                'my_field' => [
                    'terms'                      => ['value-a', 'value-b'],
                    'minimum_should_match_field' => 'required_matches',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms_set": {
                    "my_field": {
                        "terms": [
                            "value-a",
                            "value-b"
                        ],
                        "minimum_should_match_field": "required_matches"
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
    public function it_builds_the_query_for_multiple_terms_with_the_minimum_should_match_field_2()
    {
        $query = new TermsSetQuery();
        $query->field('my_field');
        $query->terms(['value-a', 'value-b']);
        $query->minimumShouldMatchScript([
            'source' => "Math.min(params.num_terms, doc['required_matches'].value)",
        ]);

        $expectedArray = [
            'terms_set' => [
                'my_field' => [
                    'terms'                       => ['value-a', 'value-b'],
                    'minimum_should_match_script' => [
                        'source' => "Math.min(params.num_terms, doc['required_matches'].value)",
                    ],
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "terms_set": {
                    "my_field": {
                        "terms": [
                            "value-a",
                            "value-b"
                        ],
                        "minimum_should_match_script": {
                            "source": "Math.min(params.num_terms, doc['required_matches'].value)"
                        }
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }
}
