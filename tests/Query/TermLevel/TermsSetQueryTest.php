<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermsSetQuery;
use Hypefactors\ElasticBuilder\QueryBuilder;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;

class TermsSetQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query_for_a_single_term()
    {
        $termsSetQuery = new TermsSetQuery();
        $termsSetQuery->field('name');
        $termsSetQuery->term('a-value');
        $termsSetQuery->minimumShouldMatchField('required_matches');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($termsSetQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($termsSetQuery) {
                $query->termsSet($termsSetQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'terms_set' => [
                'name' => [
                    'terms' => ['a-value'],
                    'minimum_should_match_field' => 'required_matches',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($termsSetQuery->isEmpty());
        $this->assertSame($expected, $termsSetQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_a_single_term_with_the_boost_factor_parameter()
    {
        $termsSetQuery = new TermsSetQuery();
        $termsSetQuery->field('name');
        $termsSetQuery->term('a-value');
        $termsSetQuery->boost(1.5);
        $termsSetQuery->minimumShouldMatchField('required_matches');

        $expected = [
            'terms_set' => [
                'name' => [
                    'terms' => ['a-value'],
                    'boost' => 1.5,
                    'minimum_should_match_field' => 'required_matches',
                ],
            ],
        ];

        $this->assertFalse($termsSetQuery->isEmpty());
        $this->assertSame($expected, $termsSetQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_a_single_term_with_the_name_parameter()
    {
        $termsSetQuery = new TermsSetQuery();
        $termsSetQuery->field('name');
        $termsSetQuery->term('a-value');
        $termsSetQuery->name('my-query-name');
        $termsSetQuery->minimumShouldMatchField('required_matches');

        $expected = [
            'terms_set' => [
                'name' => [
                    'terms' => ['a-value'],
                    '_name' => 'my-query-name',
                    'minimum_should_match_field' => 'required_matches',
                ],
            ],
        ];

        $this->assertFalse($termsSetQuery->isEmpty());
        $this->assertSame($expected, $termsSetQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_a_single_term_with_the_minimum_should_match_field_parameter_using_the_field()
    {
        $termsSetQuery = new TermsSetQuery();
        $termsSetQuery->field('name');
        $termsSetQuery->term('value-a');
        $termsSetQuery->minimumShouldMatchField('required_matches');

        $expected = [
            'terms_set' => [
                'name' => [
                    'terms'                      => ['value-a'],
                    'minimum_should_match_field' => 'required_matches',
                ],
            ],
        ];

        $this->assertFalse($termsSetQuery->isEmpty());
        $this->assertSame($expected, $termsSetQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_a_single_term_with_the_minimum_should_match_field_parameter_using_an_array()
    {
        $termsSetQuery = new TermsSetQuery();
        $termsSetQuery->field('name');
        $termsSetQuery->term('value-a');
        $termsSetQuery->minimumShouldMatchScript([
            'source' => "Math.min(params.num_terms, doc['required_matches'].value)",
        ]);

        $expected = [
            'terms_set' => [
                'name' => [
                    'terms'                       => ['value-a'],
                    'minimum_should_match_script' => [
                        'source' => "Math.min(params.num_terms, doc['required_matches'].value)",
                    ],
                ],
            ],
        ];

        $this->assertFalse($termsSetQuery->isEmpty());
        $this->assertSame($expected, $termsSetQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_multiple_terms()
    {
        $termsSetQuery = new TermsSetQuery();
        $termsSetQuery->field('name');
        $termsSetQuery->terms(['value-a', 'value-b']);
        $termsSetQuery->minimumShouldMatchField('required_matches');

        $expected = [
            'terms_set' => [
                'name' => [
                    'terms' => ['value-a', 'value-b'],
                    'minimum_should_match_field' => 'required_matches',
                ],
            ],
        ];

        $this->assertFalse($termsSetQuery->isEmpty());
        $this->assertSame($expected, $termsSetQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_multiple_terms_with_the_boost_factor_parameter()
    {
        $termsSetQuery = new TermsSetQuery();
        $termsSetQuery->field('name');
        $termsSetQuery->terms(['value-a', 'value-b']);
        $termsSetQuery->boost(1.5);
        $termsSetQuery->minimumShouldMatchField('required_matches');

        $expected = [
            'terms_set' => [
                'name' => [
                    'terms' => ['value-a', 'value-b'],
                    'boost' => 1.5,
                    'minimum_should_match_field' => 'required_matches',
                ],
            ],
        ];

        $this->assertFalse($termsSetQuery->isEmpty());
        $this->assertSame($expected, $termsSetQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_multiple_terms_with_the_name_parameter()
    {
        $termsSetQuery = new TermsSetQuery();
        $termsSetQuery->field('name');
        $termsSetQuery->terms(['value-a', 'value-b']);
        $termsSetQuery->name('my-query-name');
        $termsSetQuery->minimumShouldMatchField('required_matches');

        $expected = [
            'terms_set' => [
                'name' => [
                    'terms' => ['value-a', 'value-b'],
                    '_name' => 'my-query-name',
                    'minimum_should_match_field' => 'required_matches',
                ],
            ],
        ];

        $this->assertFalse($termsSetQuery->isEmpty());
        $this->assertSame($expected, $termsSetQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_multiple_terms_with_the_minimum_should_match_field_parameter_using_the_field()
    {
        $termsSetQuery = new TermsSetQuery();
        $termsSetQuery->field('name');
        $termsSetQuery->terms(['value-a', 'value-b']);
        $termsSetQuery->minimumShouldMatchField('required_matches');

        $expected = [
            'terms_set' => [
                'name' => [
                    'terms'                      => ['value-a', 'value-b'],
                    'minimum_should_match_field' => 'required_matches',
                ],
            ],
        ];

        $this->assertFalse($termsSetQuery->isEmpty());
        $this->assertSame($expected, $termsSetQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_for_multiple_terms_with_the_minimum_should_match_field_parameter_using_an_array()
    {
        $termsSetQuery = new TermsSetQuery();
        $termsSetQuery->field('name');
        $termsSetQuery->terms(['value-a', 'value-b']);
        $termsSetQuery->minimumShouldMatchScript([
            'source' => "Math.min(params.num_terms, doc['required_matches'].value)",
        ]);

        $expected = [
            'terms_set' => [
                'name' => [
                    'terms'                       => ['value-a', 'value-b'],
                    'minimum_should_match_script' => [
                        'source' => "Math.min(params.num_terms, doc['required_matches'].value)",
                    ],
                ],
            ],
        ];

        $this->assertFalse($termsSetQuery->isEmpty());
        $this->assertSame($expected, $termsSetQuery->build());
    }
}
