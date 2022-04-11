<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\TermLevel\FuzzyQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class FuzzyQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');

        $expectedArray = [
            'fuzzy' => [
                'user' => 'ki',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fuzzy": {
                    "user": "ki"
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_boost_factor_parameter()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->boost(1.0);

        $expectedArray = [
            'fuzzy' => [
                'user' => [
                    'value' => 'ki',
                    'boost' => 1.0,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fuzzy": {
                    "user": {
                        "value": "ki",
                        "boost": 1
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
    public function it_builds_the_query_with_the_name_parameter()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->name('my-query-name');

        $expectedArray = [
            'fuzzy' => [
                'user' => [
                    'value' => 'ki',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fuzzy": {
                    "user": {
                        "value": "ki",
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
    public function it_builds_the_query_with_the_fuziness_parameter()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->fuzziness(2);

        $expectedArray = [
            'fuzzy' => [
                'user' => [
                    'value'     => 'ki',
                    'fuzziness' => 2,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fuzzy": {
                    "user": {
                        "value": "ki",
                        "fuzziness": 2
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
    public function it_builds_the_query_with_the_max_expansions_parameter()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->maxExpansions(100);

        $expectedArray = [
            'fuzzy' => [
                'user' => [
                    'value'          => 'ki',
                    'max_expansions' => 100,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fuzzy": {
                    "user": {
                        "value": "ki",
                        "max_expansions": 100
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
    public function it_builds_the_query_with_the_prefix_length_parameter()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->prefixLength(1);

        $expectedArray = [
            'fuzzy' => [
                'user' => [
                    'value'         => 'ki',
                    'prefix_length' => 1,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fuzzy": {
                    "user": {
                        "value": "ki",
                        "prefix_length": 1
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
    public function it_builds_the_query_with_transpositions_parameter_to_true()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->transpositions(true);

        $expectedArray = [
            'fuzzy' => [
                'user' => [
                    'value'          => 'ki',
                    'transpositions' => true,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fuzzy": {
                    "user": {
                        "value": "ki",
                        "transpositions": true
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
    public function it_builds_the_query_with_transpositions_parameter_to_false()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->transpositions(false);

        $expectedArray = [
            'fuzzy' => [
                'user' => [
                    'value'          => 'ki',
                    'transpositions' => false,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "fuzzy": {
                    "user": {
                        "value": "ki",
                        "transpositions": false
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
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new FuzzyQuery();
        $query->toArray();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_parameter_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "value" is required!');

        $query = new FuzzyQuery();
        $query->field('user');

        $query->toArray();
    }
}
